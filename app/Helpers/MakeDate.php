<?php

namespace App\Helpers;

use Hekmatinasser\Verta\Verta;
use phpDocumentor\Reflection\Types\True_;

class MakeDate
{
    public static function makeGregorianDate(array $date)
    {
        $gregorianArrayDate = Verta::getGregorian($date[0], $date[1], $date[2]);
        $gregorianDate = new \DateTime(implode('-', $gregorianArrayDate) . ' ' . $date[3]);
        return $gregorianDate;
    }
}
