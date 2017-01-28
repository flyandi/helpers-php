<?php
/**
 * flyandi:php-helper
 *
 * Test for function FromArrayObject
 */

use PHPUnit_Framework_TestCase;

class FromArrayObjectTests extends PHPUnit_Framework_TestCase {

    public function testFromArrayObject() { 
        	$array = "";
	$key = "";
	$value = "";
	//$returnKey = "";
        $result = FromArrayObject($array, $key, $value, /*$returnKey*/);

        return $this->assertEquals(true, $result);
    }
}