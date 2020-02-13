<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Family;
use App\Entity\FosterParent;
use App\Entity\Region;
use App\Entity\SubRegion;
use App\Helpers\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("family", name="family_")
 */
class FamilyController extends AbstractController {

    /**
     * @Route("/all", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getAll(SerializerInterface $serializer, EntityManagerInterface $entityManager, UserInterface $user = null) {
        $allFamilies = $entityManager->getRepository(Family::class)->findAllBelongToWarden($user->getId());

        $allFamiliesJson = $serializer->serialize($allFamilies, 'json');

        return new Response($allFamiliesJson);
    }


    /**
     * @Route("/{id}", methods={"GET"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function getById($id, EntityManagerInterface $entityManager, SerializerInterface $serializer, UserInterface $user = null) {
        $family = $entityManager->getRepository(Family::class)->findByIdBelongToWarden($id, $user->getId());

        if(!$family) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $titular = $req->get("titular"); // "man" || "woman"

        $womanFirstName = $req->get("womanFirstName");
        $womanSecondName = $req->get("womanSecondName");
        $womanLastName = $req->get("womanLastName");
        $womanEgn = $req->get("womanEgn");
        $womanPhone = $req->get("womanPhone");
        $womanEducation = $req->get("womanEducation");
        $womanWork = $req->get("womanWork");
        $womanEmploymentType = $req->get("womanEmploymentType");
        $womanCitizenship = $req->get("womanCitizenship");

        $manFirstName = $req->get("manFirstName");
        $manSecondName = $req->get("manSecondName");
        $manLastName = $req->get("manLastName");
        $manEgn = $req->get("manEgn");
        $manPhone = $req->get("manPhone");
        $manEducation = $req->get("manEducation");
        $manWork = $req->get("manWork");
        $manEmploymentType = $req->get("employmentType");
        $manCitizenship = $req->get("manCitizenship");

        $preferKidGender = $req->get("preferKidGender");
        $preferKidMinAge = $req->get("preferKidMinAge");
        $preferKidMaxAge = $req->get("preferKidMaxAge");

        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");
        $address = $req->get("address");

        $language = $req->get("language");
        $levelOfBulgarianLanguage = $req->get("levelOfBulgarianLanguage");
        $religion = $req->get("religion");

        $familyType = $req->get("familyType");
        $averageMonthlyIncomePerFamilyMember = $req->get("averageMonthlyIncomePerFamilyMember");
        $anotherIncome = $req->get("anotherIncome");
        $houseType = $req->get("houseType");

        $wardenId = $req->get("wardenId");

        $womanIsEmpty = Validator::checkEmptyFields([$womanFirstName, $womanSecondName, $womanLastName, $womanEgn, $womanPhone, $womanEducation]);
        $manIsEmpty = Validator::checkEmptyFields([$manFirstName, $manSecondName, $manLastName, $manEgn, $manPhone, $manEducation]);

        if(Validator::checkEmptyFields([$titular]) || $womanIsEmpty && $manIsEmpty) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;
        if($averageMonthlyIncomePerFamilyMember == "") $averageMonthlyIncomePerFamilyMember = null;
        if($anotherIncome == "") $anotherIncome = null;

        $family = new Family();
        $family->setTitular($titular);

        if(!$womanIsEmpty) {
            $woman = new FosterParent();
            $woman->setFirstName($womanFirstName);
            $woman->setSecondName($womanSecondName);
            $woman->setLastName($womanLastName);
            $woman->setEgn($womanEgn);
            $woman->setPhone($womanPhone);
            $woman->setEducation($womanEducation);
            $woman->setWork($womanWork);
            $woman->setEmploymentType($womanEmploymentType);
            $woman->setCitizenship($womanCitizenship);

            $family->setWoman($woman);
        }

        if(!$manIsEmpty) {
            $man = new FosterParent();
            $man->setFirstName($manFirstName);
            $man->setSecondName($manSecondName);
            $man->setLastName($manLastName);
            $man->setEgn($manEgn);
            $man->setPhone($manPhone);
            $man->setEducation($manEducation);
            $man->setWork($manWork);
            $man->setEmploymentType($manEmploymentType);
            $man->setCitizenship($manCitizenship);

            $family->setMan($man);
        }

        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $family->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $family->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $family->setCity($city);

        $family->setAddress($address);

        $family->setLanguage($language);
        $family->setLevelOfBulgarianLanguage($levelOfBulgarianLanguage);
        $family->setReligion($religion);

        $family->setFamilyType($familyType);
        $family->setAverageMonthlyIncomePerFamilyMember($averageMonthlyIncomePerFamilyMember);
        $family->setAnotherIncome($anotherIncome);
        $family->setHouseType($houseType);

        $warden = $entityManager->getRepository(EmployeeOEPG::class)->find($wardenId);
        $family->setWarden($warden);

        $entityManager->persist($family);
        $entityManager->flush();

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }

    /**
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $titular = $req->get("titular"); // "man" || "woman"

        $womanFirstName = $req->get("womanFirstName");
        $womanSecondName = $req->get("womanSecondName");
        $womanLastName = $req->get("womanLastName");
        $womanEgn = $req->get("womanEgn");
        $womanPhone = $req->get("womanPhone");
        $womanEducation = $req->get("womanEducation");
        $womanWork = $req->get("womanWork");
        $womanEmploymentType = $req->get("womanEmploymentType");
        $womanCitizenship = $req->get("womanCitizenship");

        $manFirstName = $req->get("manFirstName");
        $manSecondName = $req->get("manSecondName");
        $manLastName = $req->get("manLastName");
        $manEgn = $req->get("manEgn");
        $manPhone = $req->get("manPhone");
        $manEducation = $req->get("manEducation");
        $manWork = $req->get("manWork");
        $manEmploymentType = $req->get("manEmploymentType");
        $manCitizenship = $req->get("manCitizenship");

        $preferKidGender = $req->get("preferKidGender");
        $preferKidMinAge = $req->get("preferKidMinAge");
        $preferKidMaxAge = $req->get("preferKidMaxAge");

        $regionId = $req->get("regionId");
        $subRegionId = $req->get("subRegionId");
        $cityId = $req->get("cityId");
        $address = $req->get("address");

        $language = $req->get("language");
        $levelOfBulgarianLanguage = $req->get("levelOfBulgarianLanguage");
        $religion = $req->get("religion");

        $familyType = $req->get("familyType");
        $averageMonthlyIncomePerFamilyMember = $req->get("averageMonthlyIncomePerFamilyMember");
        $anotherIncome = $req->get("anotherIncome");
        $houseType = $req->get("houseType");

        $wardenId = $req->get("wardenId");

        $womanIsEmpty = Validator::checkEmptyFields([$womanFirstName, $womanSecondName, $womanLastName, $womanEgn, $womanPhone, $womanEducation]);
        $manIsEmpty = Validator::checkEmptyFields([$manFirstName, $manSecondName, $manLastName, $manEgn, $manPhone, $manEducation]);

        if(Validator::checkEmptyFields([$titular]) || $womanIsEmpty && $manIsEmpty) {
            return new Response("All fields are required.", Response::HTTP_BAD_REQUEST);
        }

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;
        if($averageMonthlyIncomePerFamilyMember == "") $averageMonthlyIncomePerFamilyMember = null;
        if($anotherIncome == "") $anotherIncome = null;

        $family = $entityManager->getRepository(Family::class)->find($id);

        $family->setTitular($titular);

        if(!$womanIsEmpty) {
            $woman = new FosterParent();
            $woman->setFirstName($womanFirstName);
            $woman->setSecondName($womanSecondName);
            $woman->setLastName($womanLastName);
            $woman->setEgn($womanEgn);
            $woman->setPhone($womanPhone);
            $woman->setEducation($womanEducation);
            $woman->setWork($womanWork);
            $woman->setEmploymentType($womanEmploymentType);
            $woman->setCitizenship($womanCitizenship);

            $family->setWoman($woman);
        }

        if(!$manIsEmpty) {
            $man = new FosterParent();
            $man->setFirstName($manFirstName);
            $man->setSecondName($manSecondName);
            $man->setLastName($manLastName);
            $man->setEgn($manEgn);
            $man->setPhone($manPhone);
            $man->setEducation($manEducation);
            $man->setWork($manWork);
            $man->setEmploymentType($manEmploymentType);
            $man->setCitizenship($manCitizenship);

            $family->setMan($man);
        }

        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $family->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $family->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $family->setCity($city);

        $family->setAddress($address);

        $family->setLanguage($language);
        $family->setLevelOfBulgarianLanguage($levelOfBulgarianLanguage);
        $family->setReligion($religion);

        $family->setFamilyType($familyType);
        $family->setAverageMonthlyIncomePerFamilyMember($averageMonthlyIncomePerFamilyMember);
        $family->setAnotherIncome($anotherIncome);
        $family->setHouseType($houseType);

        $warden = $entityManager->getRepository(EmployeeOEPG::class)->find($wardenId);
        $family->setWarden($warden);

        $entityManager->persist($family);
        $entityManager->flush();

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }

    /**
     * @Route("/delete/{id}", methods={"DELETE"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function delete($id, Request $req, EntityManagerInterface $entityManager) {
        $family = $entityManager->getRepository(Family::class)->find($id);

        if(!$family) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($family);
        $entityManager->flush();

        // check if family was deleted
        $family = $entityManager->getRepository(Family::class)->find($id);
        if($family) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null);
    }

}