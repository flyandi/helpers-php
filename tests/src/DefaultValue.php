<?php
/**
 * flyandi:php-helper
 *
 * Test for function DefaultValue
 */

use PHPUnit_Framework_TestCase;

class DefaultValueTests extends PHPUnit_Framework_TestCase {

    public function testDefaultValue() { 
        	$value = "";
	//$default = "";
        $result = DefaultValue($value, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}