<?php

define('SELENIUM_HOST', 'http://localhost:4444/wd/hub');
require_once dirname(__FILE__).'/../../vendor/autoload.php';
require_once dirname(__FILE__).'/common/CommonIncludes.php';


use djsharman\logger\Logger;
use Icicle\Loop;
use common\CleanupBrowsers;
use common\Browser;

class LoadBrowsersExample {

    public function startBrowsers() {
        $browser_count = 10;

        Logger::alert($this, "Starting browser tests");

        \Icicle\Coroutine\create(function() use ($browser_count) {

            Logger::alert($this, "Cleaning up all browsers");
            yield from CleanupBrowsers::doCleanup();

            Logger::alert($this, "Creating $browser_count browsers");


            $Browsers = [];

            for ($i = 0; $i < $browser_count; $i++) {

                Logger::alert($this, "Adding coroutine for browser: $i");

                // make a new browser in a coroutine so we can create them in parallel
                \Icicle\Coroutine\create(function() use ($i) {
                    yield from $this->createBrowserInst($i);
                })->then(
                    null,
                    function(\Exception $e) use ($i) {
                        Logger::error($this, "Coroutine from browser $i had an exception");
                        $msg = $e->getMessage();
                        Logger::error($this, "Error message was: $msg");
                    }
                );
            }

            Logger::alert($this, 'Browsers created');
        })->then(
            function() {
                Logger::warning($this, "Primary coroutine ended");
            },
            function(\Exception $e) {
                Logger::error($this, "Primary coroutine had an exception");
                $msg = $e->getMessage();
                Logger::error($this, "Error message was: $msg");
            }
        );


        Logger::alert($this, "Running coroutines");
        Loop\run();

        Logger::alert($this, "Example coroutines have all ended");


    }

    private function createBrowserInst(int $i) {
        try {
            Logger::alert($this, "Creating browser: $i");
            $Browser = new Browser();

            $Browsers[] = $Browser;

            // create a selenium browser instance
            yield from $Browser->createBrowser();

            // navigate to the google homepage
            yield from $Browser->setURL('http://www.google.co.uk');

            $Browsers[] = $Browser;
            Logger::alert($this, "Browser: $i created");
        } catch (Exception $e) {
            Logger::critical($this, "An error occurred while creating $i.th user browser");
            Logger::critical($this, 'Exception msg:' . $e->getMessage());

        }
    }

}

$LoadBrowsersExample = new LoadBrowsersExample();
$LoadBrowsersExample->startBrowsers();