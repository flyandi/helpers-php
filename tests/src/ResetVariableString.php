<?php
/**
 * flyandi:php-helper
 *
 * Test for function ResetVariableString
 */

use PHPUnit_Framework_TestCase;

class ResetVariableStringTests extends PHPUnit_Framework_TestCase {

    public function testResetVariableString() { 
        	$string = "";
	//$st = "";
	//$et = "";
        $result = ResetVariableString($string, /*$st*/, /*$et*/);

        return $this->assertEquals(true, $result);
    }
}