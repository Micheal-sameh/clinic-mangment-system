<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

class UserStatus
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;

    public const PENDING = 3;

    public static function all()
    {
        App::isLocale('ar') ?
            $grad = [
                [
                    "name" => 'مفعل',
                    "value" => self::ACTIVE,
                ],
                [
                    "name" => 'غير مقعل',
                    "value" => self::INACTIVE,
                ],
                [
                    "name" => 'قيد الانتظار',
                    "value" => self::PENDING,
                ],
            ]
            :
            $grad = [
                [
                    "name" => 'Active',
                    "value" => self::ACTIVE,
                ],
                [
                    "name" => 'In Actice',
                    "value" => self::INACTIVE,
                ],
                [
                    "name" => 'Pending',
                    "value" => self::PENDING,
                ],
            ];
        return $grad;
    }

    public static function getStringValue($value): string
    {
        $locale =  app()->getLocale();
        switch ($value) {
            case self::ACTIVE:
                return ($locale == 'en') ? 'Active' : 'مفعل';
            case self::INACTIVE:
                return ($locale == 'en') ? 'In Active' : 'غير مفعل';
            case self::PENDING:
                return ($locale == 'en') ? 'Pending' : 'قيد الانتظار';
            default:
                return '';
        }
    }
}
