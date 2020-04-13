<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\City;
use App\Entity\EmployeeOEPG;
use App\Entity\Family;
use App\Entity\FosterParent;
use App\Entity\Region;
use App\Entity\SubRegion;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Constants\Roles;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/{familyId}/add_child", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function addChild($familyId, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $childId = $req->get("childId");

        $family = $entityManager->getRepository(Family::class)->find($familyId);

        if(!$family) {
            return new Response("Family not found.", Response::HTTP_NOT_FOUND);
        }

        $child = $entityManager->getRepository(Child::class)->find($childId);

        if(!$child) {
            return new Response("Child not found.", Response::HTTP_NOT_FOUND);
        }

        $family->addChild($child);

        $entityManager->persist($family);
        $entityManager->flush();

        $childJson = $serializer->serialize($child, 'json');

        return new Response($childJson, Response::HTTP_OK);
    }


    /**
     * @Route("/{familyId}/remove_child", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function removeChild($familyId, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $childId = $req->get("childId");

        $family = $entityManager->getRepository(Family::class)->find($familyId);

        if(!$family) {
            return new Response("Family not found", Response::HTTP_NOT_FOUND);
        }

        $child = $entityManager->getRepository(Child::class)->find($childId);

        if(!$child) {
            return new Response("Child not found.", Response::HTTP_NOT_FOUND);
        }

        $family->removeChild($child);

        $entityManager->persist($family);
        $entityManager->flush();

        $childJson = $serializer->serialize($child, 'json');

        return new Response($childJson, Response::HTTP_OK);
    }


    /**
     * @Route("/register", methods={"POST"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function register(Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $titular = trim($req->get("titular"));

        $womanFirstName = trim($req->get("womanFirstName"));
        $womanSecondName = trim($req->get("womanSecondName"));
        $womanLastName = trim($req->get("womanLastName"));
        $womanEgn = trim($req->get("womanEgn"));
        $womanPhone = trim($req->get("womanPhone"));
        $womanEducation = trim($req->get("womanEducation"));
        $womanWork = trim($req->get("womanWork"));
        $womanEmploymentType = trim($req->get("womanEmploymentType"));
        $womanCitizenship = trim($req->get("womanCitizenship"));

        $manFirstName = trim($req->get("manFirstName"));
        $manSecondName = trim($req->get("manSecondName"));
        $manLastName = trim($req->get("manLastName"));
        $manEgn = trim($req->get("manEgn"));
        $manPhone = trim($req->get("manPhone"));
        $manEducation = trim($req->get("manEducation"));
        $manWork = trim($req->get("manWork"));
        $manEmploymentType = trim($req->get("manEmploymentType"));
        $manCitizenship = trim($req->get("manCitizenship"));

        $preferKidGender = trim($req->get("preferKidGender"));
        $preferKidMinAge = trim($req->get("preferKidMinAge"));
        $preferKidMaxAge = trim($req->get("preferKidMaxAge"));

        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));
        $address = trim($req->get("address"));

        $language = trim($req->get("language"));
        $levelOfBulgarianLanguage = trim($req->get("levelOfBulgarianLanguage"));
        $religion = trim($req->get("religion"));

        $familyType = trim($req->get("familyType"));
        $averageMonthlyIncomePerFamilyMember = trim($req->get("averageMonthlyIncomePerFamilyMember"));
        $anotherIncome = trim($req->get("anotherIncome"));
        $houseType = trim($req->get("houseType"));

        $wardenId = trim($req->get("wardenId"));

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;
        if($averageMonthlyIncomePerFamilyMember == "") $averageMonthlyIncomePerFamilyMember = null;
        if($anotherIncome == "") $anotherIncome = null;

        $family = new Family();
        $family->setTitular($titular);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $family->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $family->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $family->setCity($city);

        $family->setAddress($address);

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
        $woman->setGender("woman");
        $woman->setRegion($region);
        $woman->setSubRegion($subRegion);
        $woman->setCity($city);
        $woman->setAddress($address);

        $family->setWoman($woman);

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
        $man->setGender("man");
        $man->setRegion($region);
        $man->setSubRegion($subRegion);
        $man->setCity($city);
        $man->setAddress($address);

        $family->setMan($man);

        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $family->setLanguage($language);
        $family->setLevelOfBulgarianLanguage($levelOfBulgarianLanguage);
        $family->setReligion($religion);

        $family->setFamilyType($familyType);
        $family->setAverageMonthlyIncomePerFamilyMember($averageMonthlyIncomePerFamilyMember);
        $family->setAnotherIncome($anotherIncome);
        $family->setHouseType($houseType);

        $warden = $entityManager->getRepository(EmployeeOEPG::class)->find($wardenId);
        $family->setWarden($warden);

        $errors = $validator->validate($family);
        if(count($errors) > 0) {
            return new Response((string) $errors, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($family);
        $entityManager->flush();

        $familyJson = $serializer->serialize($family, 'json');

        return new Response($familyJson);
    }


    /**
     * @Route("/update/{id}", methods={"PUT"})
     * @IsGranted(Roles::ROLE_OEPG)
     */
    public function update($id, Request $req, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator) {
        $titular = trim($req->get("titular"));

        $womanFirstName = trim($req->get("womanFirstName"));
        $womanSecondName = trim($req->get("womanSecondName"));
        $womanLastName = trim($req->get("womanLastName"));
        $womanEgn = trim($req->get("womanEgn"));
        $womanPhone = trim($req->get("womanPhone"));
        $womanEducation = trim($req->get("womanEducation"));
        $womanWork = trim($req->get("womanWork"));
        $womanEmploymentType = trim($req->get("womanEmploymentType"));
        $womanCitizenship = trim($req->get("womanCitizenship"));

        $manFirstName = trim($req->get("manFirstName"));
        $manSecondName = trim($req->get("manSecondName"));
        $manLastName = trim($req->get("manLastName"));
        $manEgn = trim($req->get("manEgn"));
        $manPhone = trim($req->get("manPhone"));
        $manEducation = trim($req->get("manEducation"));
        $manWork = trim($req->get("manWork"));
        $manEmploymentType = trim($req->get("manEmploymentType"));
        $manCitizenship = trim($req->get("manCitizenship"));

        $preferKidGender = trim($req->get("preferKidGender"));
        $preferKidMinAge = trim($req->get("preferKidMinAge"));
        $preferKidMaxAge = trim($req->get("preferKidMaxAge"));

        $regionId = trim($req->get("regionId"));
        $subRegionId = trim($req->get("subRegionId"));
        $cityId = trim($req->get("cityId"));
        $address = trim($req->get("address"));

        $language = trim($req->get("language"));
        $levelOfBulgarianLanguage = trim($req->get("levelOfBulgarianLanguage"));
        $religion = trim($req->get("religion"));

        $familyType = trim($req->get("familyType"));
        $averageMonthlyIncomePerFamilyMember = trim($req->get("averageMonthlyIncomePerFamilyMember"));
        $anotherIncome = trim($req->get("anotherIncome"));
        $houseType = trim($req->get("houseType"));

        $wardenId = trim($req->get("wardenId"));

        if($preferKidMinAge == "") $preferKidMinAge = null;
        if($preferKidMaxAge == "") $preferKidMaxAge = null;
        if($averageMonthlyIncomePerFamilyMember == "") $averageMonthlyIncomePerFamilyMember = null;
        if($anotherIncome == "") $anotherIncome = null;

        $family = $entityManager->getRepository(Family::class)->find($id);

        $family->setTitular($titular);

        $region = $entityManager->getRepository(Region::class)->find($regionId);
        $family->setRegion($region);

        $subRegion = $entityManager->getRepository(SubRegion::class)->find($subRegionId);
        $family->setSubRegion($subRegion);

        $city = $entityManager->getRepository(City::class)->find($cityId);
        $family->setCity($city);

        $family->setAddress($address);

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
        $woman->setGender("man");
        $woman->setRegion($region);
        $woman->setSubRegion($subRegion);
        $woman->setCity($city);
        $woman->setAddress($address);

        $family->setWoman($woman);

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
        $man->setGender("man");
        $man->setRegion($region);
        $man->setSubRegion($subRegion);
        $man->setCity($city);
        $man->setAddress($address);

        $family->setMan($man);

        $family->setPreferKidGender($preferKidGender);
        $family->setPreferKidMinAge($preferKidMinAge);
        $family->setPreferKidMaxAge($preferKidMaxAge);

        $family->setLanguage($language);
        $family->setLevelOfBulgarianLanguage($levelOfBulgarianLanguage);
        $family->setReligion($religion);

        $family->setFamilyType($familyType);
        $family->setAverageMonthlyIncomePerFamilyMember($averageMonthlyIncomePerFamilyMember);
        $family->setAnotherIncome($anotherIncome);
        $family->setHouseType($houseType);

        $warden = $entityManager->getRepository(EmployeeOEPG::class)->find($wardenId);
        $family->setWarden($warden);

        $errors = $validator->validate($family);
        if(count($errors) > 0) {
            return new Response((string) $errors, Response::HTTP_BAD_REQUEST);
        }

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