<?php


namespace App\Supports;


class Tools
{
    public static function formatNameWithTitle($string): string
    {
        $pos = strpos($string, ',');
        $title = $name = '';
        if ($pos !== false) {
            $name = substr($string, 0, $pos);
            $title = substr($string, $pos, strlen($string));
            return (ucwords(strtolower($name)) . $title);
        }

        return $string;
    }
}
