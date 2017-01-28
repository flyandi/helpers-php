<?php
/**
 * flyandi:php-helper
 *
 * Test for function ParseRequest
 */

use PHPUnit_Framework_TestCase;

class ParseRequestTests extends PHPUnit_Framework_TestCase {

    public function testParseRequest() { 
        	$request = "";
	//$asobject = "";
        $result = ParseRequest($request, /*$asobject*/);

        return $this->assertEquals(true, $result);
    }
}