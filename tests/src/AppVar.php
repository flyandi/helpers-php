<?php
/**
 * flyandi:php-helper
 *
 * Test for function AppVar
 */

use PHPUnit_Framework_TestCase;

class AppVarTests extends PHPUnit_Framework_TestCase {

    public function testAppVar() { 
        	$name = "";
	//$default = "";
        $result = AppVar($name, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}