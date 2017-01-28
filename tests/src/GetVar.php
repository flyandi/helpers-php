<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetVar
 */

use PHPUnit_Framework_TestCase;

class GetVarTests extends PHPUnit_Framework_TestCase {

    public function testGetVar() { 
        	$name = "";
	//$default = "";
        $result = GetVar($name, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}