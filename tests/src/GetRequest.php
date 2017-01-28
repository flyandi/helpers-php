<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetRequest
 */

use PHPUnit_Framework_TestCase;

class GetRequestTests extends PHPUnit_Framework_TestCase {

    public function testGetRequest() { 
        	//$index = "";
	//$prepend = "";
	//$removequery = "";
        $result = GetRequest(/*$index*/, /*$prepend*/, /*$removequery*/);

        return $this->assertEquals(true, $result);
    }
}