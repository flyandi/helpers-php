<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetVarEx
 */

use PHPUnit_Framework_TestCase;

class GetVarExTests extends PHPUnit_Framework_TestCase {

    public function testGetVarEx() { 
        	$name = "";
	//$variables = "";
	//$default = "";
        $result = GetVarEx($name, /*$variables*/, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}