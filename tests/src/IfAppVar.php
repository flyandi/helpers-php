<?php
/**
 * flyandi:php-helper
 *
 * Test for function IfAppVar
 */

use PHPUnit_Framework_TestCase;

class IfAppVarTests extends PHPUnit_Framework_TestCase {

    public function testIfAppVar() { 
        	$name = "";
	//$is = "";
        $result = IfAppVar($name, /*$is*/);

        return $this->assertEquals(true, $result);
    }
}