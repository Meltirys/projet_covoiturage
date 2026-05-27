<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Services\JourneyService;
use App\Services\LocationService;
use App\Services\MailService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function journeyService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('journeyService');
        }

        return new JourneyService();
    }

    public static function locationService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('locationService');
        }

        return new LocationService();
    }

    public static function mailService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('mailService');
        }

        return new MailService();
    }
}
