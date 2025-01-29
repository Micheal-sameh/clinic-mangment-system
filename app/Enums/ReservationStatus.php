<?php

namespace App\Enums;

use Illuminate\Support\Facades\App;

class ReservationStatus
{
    public const WAITING = 1;

    public const TOPAY = 2;

    public const PAID = 3;

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
                    "name" => 'تم الدفع',
                    "value" => self::PAID,
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
                    "name" => 'Pending payment',
                    "value" => self::TOPAY,
                ],
                [
                    "name" => 'Paid',
                    "value" => self::PAID,
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
                return ( $locale == 'en') ? 'Pending Payment' : 'انتظار الدفع';
            case self::PAID:
                return ( $locale == 'en') ? 'Paid' : 'تم الدفع';
            case self::CANCELLED:
                return ( $locale == 'en') ? 'Cancelled' : 'ملغى';
            default:
                return '';
        }
    }
}
