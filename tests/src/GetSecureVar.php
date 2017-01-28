<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetSecureVar
 */

use PHPUnit_Framework_TestCase;

class GetSecureVarTests extends PHPUnit_Framework_TestCase {

    public function testGetSecureVar() { 
        	$name = "";
	//$default = "";
        $result = GetSecureVar($name, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}