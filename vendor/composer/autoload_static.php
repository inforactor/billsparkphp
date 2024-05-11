<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitacd877d4b716904a1bfc4f7b74d4e5c4
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TelegramBot\\Api\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TelegramBot\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/telegram-bot/api/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitacd877d4b716904a1bfc4f7b74d4e5c4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitacd877d4b716904a1bfc4f7b74d4e5c4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitacd877d4b716904a1bfc4f7b74d4e5c4::$classMap;

        }, null, ClassLoader::class);
    }
}
