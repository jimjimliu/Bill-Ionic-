<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7570221807ee6b5c3eec48d6c5cc8f42
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/Twilio',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7570221807ee6b5c3eec48d6c5cc8f42::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7570221807ee6b5c3eec48d6c5cc8f42::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}