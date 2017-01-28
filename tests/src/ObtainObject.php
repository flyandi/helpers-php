<?php
/**
 * flyandi:php-helper
 *
 * Test for function ObtainObject
 */

use PHPUnit_Framework_TestCase;

class ObtainObjectTests extends PHPUnit_Framework_TestCase {

    public function testObtainObject() { 
        	$input = "";
        $result = ObtainObject($input);

        return $this->assertEquals(true, $result);
    }
}