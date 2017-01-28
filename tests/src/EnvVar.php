<?php
/**
 * flyandi:php-helper
 *
 * Test for function EnvVar
 */

use PHPUnit_Framework_TestCase;

class EnvVarTests extends PHPUnit_Framework_TestCase {

    public function testEnvVar() { 
        	$name = "";
	//$default = "";
        $result = EnvVar($name, /*$default*/);

        return $this->assertEquals(true, $result);
    }
}