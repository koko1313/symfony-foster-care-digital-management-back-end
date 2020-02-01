<?php

namespace App\HardcoredData;

class HardcoredUsers
{
    public static function getAll()
    {
        return $data = [
            [
                "id" => "1",
                "email" => "admin@admin.com",
                "position" => "Global administrator",
                "password" => "1234",
                "first_name" => "",
                "last_name" => "",
                "region" => "",
                "municipality" => "",
                "manage_district" => [],
                "roles" => ["ROLE_ADMIN"]
            ],
            [
                "id" => "2",
                "email" => "admin-montana@admin.com",
                "position" => "Regional administrator",
                "password" => "1234",
                "first_name" => "",
                "last_name" => "",
                "region" => "Монтана",
                "municipality" => "Монтана",
                "manage_district" => [],
                "roles" => ["ROLE_REGIONAL_ADMIN"]
            ],
            [
                "id" => "3",
                "email" => "sonya@employee.com",
                "position" => "ОЕПГ",
                "password" => "1234",
                "first_name" => "Соня",
                "last_name" => "Златкова",
                "region" => "Монтана",
                "municipality" => "Лом",
                "manage_district" => ["Лом", "Брусарци"],
                "roles" => ["ROLE_OEPG"]
            ]
        ];
    }
}