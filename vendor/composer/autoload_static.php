<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita817089c0356a5102fb284b1ac35ea1e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita817089c0356a5102fb284b1ac35ea1e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita817089c0356a5102fb284b1ac35ea1e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}