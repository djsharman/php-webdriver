<?php
namespace common;

use djsharman\logger\Logger;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class CleanupBrowsers {

    public static function doCleanup() {
        Logger::info(null, "Cleaning browsers from previous runs");

        $hosts = explode('|', SELENIUM_HOST);


        foreach ($hosts as $host) {

            // kill any leftover sessions from previous runs
            $Sessions = yield from RemoteWebDriver::getAllSessions($host);
            /**
             * @var $Session RemoteWebDriver
             */
            foreach ($Sessions as $Session) {
                $id     = $Session['id'];
                $driver = RemoteWebDriver::createBySessionID($id, $host);
                yield from $driver->quit();
            }
        }
    }

}