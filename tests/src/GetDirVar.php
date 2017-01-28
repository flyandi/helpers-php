<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetDirVar
 */

use PHPUnit_Framework_TestCase;

class GetDirVarTests extends PHPUnit_Framework_TestCase {

    public function testGetDirVar() { 
        	//$index = "";
	//$default = "";
	//$path = "";
        $result = GetDirVar(/*$index*/, /*$default*/, /*$path*/);

        return $this->assertEquals(true, $result);
    }
}