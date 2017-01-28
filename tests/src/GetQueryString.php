<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetQueryString
 */

use PHPUnit_Framework_TestCase;

class GetQueryStringTests extends PHPUnit_Framework_TestCase {

    public function testGetQueryString() { 
        	//$asarray = "";
	//$withqm = "";
	//$default = "";
	//$fromstring = "";
        $result = GetQueryString(/*$asarray*/, /*$withqm*/, /*$default*/, /*$fromstring*/);

        return $this->assertEquals(true, $result);
    }
}