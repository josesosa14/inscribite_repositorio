<?php
/**
 * Created by PhpStorm.
 * User: raulmatias
 * Date: 30/11/2015
 * Time: 10:02 PM
 */

include_once 'mobiledetect/Mobile_Detect.php';

/**
 * Class Mobdetector
 * @property Mobile_Detect $mobile_detect
 */
class Mobdetector {

    private $mobile_detect;

    function __construct()    {
        $this->mobile_detect = new Mobile_Detect();
    }

    function isCelular()
    {
        if ($this->mobile_detect->isMobile() && !$this->mobile_detect->isTablet()) {
            return TRUE;
        } else {
            return FALSE;
        }

    }
}

