<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetHTTPHeaderVar
 */

use PHPUnit_Framework_TestCase;

class GetHTTPHeaderVarTests extends PHPUnit_Framework_TestCase {

    public function testGetHTTPHeaderVar() { 
        	$name = "";
	//$default = "";
        $result = GetHTTPHeaderVar($name, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}