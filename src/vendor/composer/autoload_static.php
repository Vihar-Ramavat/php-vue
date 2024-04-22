<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbd41f372787cd6de5a5a27712def4750
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SimpleSoftwareIO\\QrCode\\' => 24,
        ),
        'J' => 
        array (
            'JeroenDesloovere\\VCard\\' => 23,
        ),
        'D' => 
        array (
            'DASPRiD\\Enum\\' => 13,
        ),
        'B' => 
        array (
            'Behat\\Transliterator\\' => 21,
            'BaconQrCode\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SimpleSoftwareIO\\QrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/simplesoftwareio/simple-qrcode/src',
        ),
        'JeroenDesloovere\\VCard\\' => 
        array (
            0 => __DIR__ . '/..' . '/jeroendesloovere/vcard/src',
        ),
        'DASPRiD\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/dasprid/enum/src',
        ),
        'Behat\\Transliterator\\' => 
        array (
            0 => __DIR__ . '/..' . '/behat/transliterator/src/Behat/Transliterator',
        ),
        'BaconQrCode\\' => 
        array (
            0 => __DIR__ . '/..' . '/bacon/bacon-qr-code/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbd41f372787cd6de5a5a27712def4750::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbd41f372787cd6de5a5a27712def4750::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbd41f372787cd6de5a5a27712def4750::$classMap;

        }, null, ClassLoader::class);
    }
}
