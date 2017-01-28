<?php
/**
 * flyandi:php-helper
 *
 * Test for function SetServerVar
 */

use PHPUnit_Framework_TestCase;

class SetServerVarTests extends PHPUnit_Framework_TestCase {

    public function testSetServerVar() { 
        	$name = "";
	$value = "";
        $result = SetServerVar($name, $value);

        return $this->assertEquals(true, $result);
    }
}