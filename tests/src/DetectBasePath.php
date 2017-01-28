<?php
/**
 * flyandi:php-helper
 *
 * Test for function DetectBasePath
 */

use PHPUnit_Framework_TestCase;

class DetectBasePathTests extends PHPUnit_Framework_TestCase {

    public function testDetectBasePath() { 
        	//$includeFullPath = "";
	//$default = "";
        $result = DetectBasePath(/*$includeFullPath*/, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}