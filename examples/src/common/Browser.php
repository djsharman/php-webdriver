<?php
namespace common;

/**
 * Wraps Browser functions
 */

use common\BrowserCaps;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverExpectedCondition;


class Browser {

    /**
     * @var $Browser RemoteWebDriver
     */
    private $Browser = null;

    /**
     * Creates a browser
     *
     * @return RemoteWebDriver|\Generator
     * @throws \Facebook\WebDriver\Exception\WebDriverException
     */
    public function createBrowser() {
        $capabilities = BrowserCaps::getDefaultCapabilities();

        /** @var RemoteWebDriver $driver */
        $driver = yield from RemoteWebDriver::create(SELENIUM_HOST, $capabilities, 5000);

        $Manage = $driver->manage();
        $WebDriverWindow = $Manage->window();

        $Dim = new WebDriverDimension(1880, 920);
        yield from $WebDriverWindow->setSize($Dim);

        $WebDriverTimeouts =  $Manage->timeouts();
        yield from $WebDriverTimeouts->implicitlyWait(10);

        yield from $Manage->deleteAllCookies();

        $this->setBrowser($driver);

        return $driver;

    }


    /**
     * @param RemoteWebDriver $Browser
     *
     * @return $this
     */
    private function setBrowser(RemoteWebDriver $Browser) {
        $this->Browser = $Browser;
        return $this;
    }

    /**
     * @return RemoteWebDriver
     */
    public function getBrowser(): RemoteWebDriver {
        return $this->Browser;
    }

    /**
     * Navigates the browser window to a URL
     * @param $url
     *
     * @return \Generator
     * @throws \Exception
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function setURL($url) {

        $Browser = $this->getBrowser();

        /** @var RemoteWebDriver $RemoteWebDriver */
        $RemoteWebDriver = yield from $Browser->get($url);
        $WebDriverWait = $RemoteWebDriver->wait();
        yield from $WebDriverWait->until(
            function() use ($Browser) {
                $ret_val = yield from $Browser->executeScript("return document.readyState");
                $ret = ($ret_val == "complete");
                return $ret;
            }
        );
    }
}