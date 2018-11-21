<?php

namespace App\CustomHelpers;

class StringHelper
{

    public static function fullName($firstName, $secondName, $thirdName, $fatherLastName, $mostherLastName)
    {
        $name = $firstName . '-';
        $name .= $secondName . '-';
        $name .= $thirdName . '-';
        $name .= $fatherLastName . '-';
        $name .= $mostherLastName;
        $name = title_case($name);
        $name = str_replace(['-', '   ', '  '], ' ', $name);

        return $name;
    }

    public static function str_withoutAccent($string)
    {
        $string = str_replace(['Á', 'Ä', 'À'], 'A', $string);
        $string = str_replace(['É', 'Ë', 'È'], 'E', $string);
        $string = str_replace(['Í', 'Ï', 'Ì'], 'I', $string);
        $string = str_replace(['Á', 'Ä', 'À'], 'O', $string);
        $string = str_replace(['Á', 'Ä', 'À'], 'U', $string);
        $string = str_replace('Ñ', 'N', $string);

        return $string;
    }
}
