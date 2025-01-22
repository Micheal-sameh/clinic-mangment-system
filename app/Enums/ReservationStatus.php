<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

class ReservationStatus
{
    public const WAITING = 1;

    public const TOPAY = 2;

    public const DONE = 3;

    public const CANCELLED  = 4;

    public static function all()
    {
        App::isLocale('ar') ?
            $grad = [
                [
                    "name" => 'في الانتظار',
                    "value" => self::WAITING,
                ],
                [
                    "name" => 'في انتظار الدفع',
                    "value" => self::TOPAY,
                ],
                [
                    "name" => 'تم الزيارة',
                    "value" => self::DONE,
                ],
                [
                    "name" => 'ملغي',
                    "value" => self::CANCELLED,
                ],
            ]
            :
            $grad = [
                [
                    "name" => 'Waiting',
                    "value" => self::WAITING,
                ],
                [
                    "name" => 'Waiting for payment',
                    "value" => self::TOPAY,
                ],
                [
                    "name" => 'Done',
                    "value" => self::DONE,
                ],
                [
                    "name" => 'Cancel',
                    "value" => self::CANCELLED,
                ],
            ];
        return $grad;
    }

    public static function getStringValue($value): string
    {
        $locale =  app()->getLocale();

        switch ($value) {
            case self::WAITING:
                return ( $locale == 'en') ? 'Waiting' : 'في الانتظار';
            case self::TOPAY:
                return ( $locale == 'en') ? 'Wating Payment' : 'انتظار الدفع';
            case self::DONE:
                return ( $locale == 'en') ? 'Done' : 'تم الدفع';
            case self::CANCELLED:
                return ( $locale == 'en') ? 'Cancelled' : 'ملغى';
            default:
                return '';
        }
    }
}
