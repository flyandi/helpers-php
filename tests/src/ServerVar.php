<?php
/**
 * flyandi:php-helper
 *
 * Test for function ServerVar
 */

use PHPUnit_Framework_TestCase;

class ServerVarTests extends PHPUnit_Framework_TestCase {

    public function testServerVar() { 
        	//$name = "";
	//$default = "";
        $result = ServerVar(/*$name*/, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}