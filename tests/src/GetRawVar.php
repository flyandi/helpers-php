<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetRawVar
 */

use PHPUnit_Framework_TestCase;

class GetRawVarTests extends PHPUnit_Framework_TestCase {

    public function testGetRawVar() { 
        	//$name = "";
	//$default = "";
        $result = GetRawVar(/*$name*/, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}