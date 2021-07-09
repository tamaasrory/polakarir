<?php


namespace App\Supports;


class Tools
{
    /**
     * @param $string
     * @return string
     */
    public static function formatNameWithTitle($string): string
    {
        $findDot = strpos($string, '.');
        $frontTitle = '';
//        if ($findDot !== false) {
//            $frontTitle = substr($string, 0, $findDot);
//            $string = substr($string, $findDot, strlen($string));
//        }

        $pos = strpos($string, ',');
        $endTitle = $name = '';
        if ($pos !== false) {
            $name = substr($string, 0, $pos);
            $endTitle = substr($string, $pos, strlen($string));
            return $frontTitle . ucwords(strtolower($name)) . $endTitle;
        }

        return $string;
    }

    /**
     * @param null $path
     * @return string
     */
    public static function publicPath($path = null)
    {
        return app()->basePath('public/' . $path);
    }
}
