<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8d8e12c6952498850bf6a4d57ddd505a
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8d8e12c6952498850bf6a4d57ddd505a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8d8e12c6952498850bf6a4d57ddd505a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8d8e12c6952498850bf6a4d57ddd505a::$classMap;

        }, null, ClassLoader::class);
    }
}