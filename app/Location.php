<?php

namespace App;

class Location
{
    function Distance($lat1,$lng1,$lat2,$lng2){
        $rad = M_PI / 180;
        $theta = $lng1 - $lng2;
        $dist = sin($lat1 * $rad) * sin($lat2 * $rad) +  cos($lat1 * $rad) * cos($lat2 * $rad) * cos($theta * $rad);
        return acos($dist) / $rad * 60 *  1.853;
    }
}