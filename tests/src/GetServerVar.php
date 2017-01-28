<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetServerVar
 */

use PHPUnit_Framework_TestCase;

class GetServerVarTests extends PHPUnit_Framework_TestCase {

    public function testGetServerVar() { 
        	//$name = "";
	//$default = "";
        $result = GetServerVar(/*$name*/, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}