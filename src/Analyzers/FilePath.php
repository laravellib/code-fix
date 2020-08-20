<?php

namespace codicastudio\LaravelMicroscope\Analyzers;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class FilePath
{
    public static function normalize($path)
    {
        // for a path like:  '/usr/laravel/app\Http\..\..\database';
        $dir = \str_replace(['\\', '/', '//', '\\\\'], DIRECTORY_SEPARATOR, $path);

        $sections = \explode(DIRECTORY_SEPARATOR, $dir);

        $res = [];
        foreach ($sections as $i => $section) {
            if ($section == '..') {
                \array_pop($res);
            } else {
                $res[] = $section;
            }
        }

        return \implode(DIRECTORY_SEPARATOR, $res);
    }

    public static function getRelativePath($absFilePath)
    {
        return \trim(Str::replaceFirst(base_path(), '', $absFilePath), DIRECTORY_SEPARATOR);
    }

    /**
     * @param $path
     *
     * @return \Symfony\Component\Finder\Finder
     */
    public static function getAllPhpFiles($path)
    {
        return Finder::create()->files()->name('*.php')->in(base_path($path));
    }
}