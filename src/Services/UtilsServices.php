<?php

namespace App\Services;

class UtilsServices
{
    public function getWeekend()
    {
        $date = new \DateTime('now');
        $semaine = $date->format('W');
        $anne = $date->format('Y');
        return ((int)$semaine >9) ?$anne.'-W'.$semaine:$anne.'-W0'.$semaine;
    }
}