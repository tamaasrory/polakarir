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
        $pos = strpos($string, ',');
        $title = $name = '';
        if ($pos !== false) {
            $name = substr($string, 0, $pos);
            $title = substr($string, $pos, strlen($string));
            return (ucwords(strtolower($name)) . $title);
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
