<?php

namespace App;
use Auth;

class X
{
        
    public static function activeSeason()
    {
        return \App\Option::getOption('active_season');
    }

    public static function typeInUseSlug()
    {
        return Auth::user()->options->type_in_use->slug;
    }

    public static function brandInUseSlug()
    {
        return Auth::user()->options->brand_in_use->slug;
    }

    public static function brandInUseName()
    {
        return Auth::user()->options->brand_in_use->name;
    }

    public static function thisSeasonOrders()
    {
        return \App\Order::where('season_id', \App\X::activeSeason())->get();
    }

    public static function rangeNumbers($csv)
    {
        // split string using the , character
        $number_array = array_map('intval', array_unique($csv));
        sort($number_array);

        // Loop through array and build range string
        $previous_number = intval(array_shift($number_array)); 
        $range = false;
        $range_string = "" . $previous_number; 
        foreach ($number_array as $number) {
            $number = intval($number);
            if ($number == $previous_number + 1) {
            $range = true;
            }
            else {
            if ($range) {
                $range_string .= " - $previous_number";
                $range = false;
            }
            $range_string .= ", $number";
            }
            $previous_number = $number;
        }
        if ($range) {
            $range_string .= " - $previous_number";
        }

        return $range_string;
    }

    public static function arrayCartesianProduct($arrays)
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array)
            $size = $size * sizeof($array);
        for ($i = 0; $i < $size; $i ++)
        {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j ++)
                array_push($result[$i], current($arrays[$j]));
            for ($j = ($sizeIn -1); $j >= 0; $j --)
            {
                if (next($arrays[$j]))
                    break;
                elseif (isset ($arrays[$j]))
                    reset($arrays[$j]);
            }
        }
        return $result;
    }

}