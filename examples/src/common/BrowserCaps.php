<?php
namespace common;

/**
 * Provides browser capabilities configuration
 */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class BrowserCaps {

    /**
     * @return DesiredCapabilities
     */
    public static function getDefaultCapabilities() {
        $capabilities = DesiredCapabilities::chrome();
        // this one will make selenium download to the directory we want.

        $tmp_file_path = sys_get_temp_dir ();

        $prefs = array('download.default_directory' => $tmp_file_path,
            'download.prompt_for_download' => false,
            'download.directory_upgrade' => true );

        $options = new ChromeOptions();


        $options->setExperimentalOption('prefs', $prefs);
        $options->addArguments(["disable-infobars" ]);

        $headless = false;
        if($headless == true) {
            $options->addArguments(["headless"]);
        }

        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        return $capabilities;
    }

}