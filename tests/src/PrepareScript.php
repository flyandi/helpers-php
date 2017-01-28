<?php
/**
 * flyandi:php-helper
 *
 * Test for function PrepareScript
 */

use PHPUnit_Framework_TestCase;

class PrepareScriptTests extends PHPUnit_Framework_TestCase {

    public function testPrepareScript() { 
        	$source = "";
	//$type = "";
        $result = PrepareScript($source, /*$type*/);

        return $this->assertEquals(true, $result);
    }
}