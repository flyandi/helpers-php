<?php
/**
 * flyandi:php-helper
 *
 * Test for function StringToBool
 */

use PHPUnit_Framework_TestCase;

class StringToBoolTests extends PHPUnit_Framework_TestCase {

    public function testStringToBool() { 
        	$s = "";
        $result = StringToBool($s);

        return $this->assertEquals(true, $result);
    }
}