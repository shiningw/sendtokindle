<?php

namespace OCA\SendtoKindle;

use Exception;
use OCA\SendtoKindle\Settings;
use OCP\IUser;
use OC\Files\Filesystem;
use OC_Util;

class Helper
{
    public static function getUser(): ?IUser
    {
        return \OC::$server->getUserSession()->getUser();
    }

    public static function getUID(): string
    {
        $user = self::getUser();
        $uid = $user ? $user->getUID() : "";
        return $uid;
    }

    public static function getSettings($key, $default = null, int $type = Settings::TYPE['USER'])
    {
        $settings = self::newSettings();
        return $settings->setType($type)->get($key, $default);
    }

    public static function newSettings($uid = null)
    {
        $uid = $uid ?? self::getUID();
        return Settings::create($uid);
    }
}
