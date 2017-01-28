<?php
/**
 * flyandi:php-helper
 *
 * Test for function SetVar
 */

use PHPUnit_Framework_TestCase;

class SetVarTests extends PHPUnit_Framework_TestCase {

    public function testSetVar() { 
        	$name = "";
	//$value = "";
        $result = SetVar($name, /*$value*/);

        return $this->assertEquals(true, $result);
    }
}