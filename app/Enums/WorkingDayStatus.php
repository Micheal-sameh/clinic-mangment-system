<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

class WorkingDayStatus
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;


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
            default:
                return '';
        }
    }
}
