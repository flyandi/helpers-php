<?php
/**
 * flyandi:php-helper
 *
 * Test for function ObtainArray
 */

use PHPUnit_Framework_TestCase;

class ObtainArrayTests extends PHPUnit_Framework_TestCase {

    public function testObtainArray() { 
        	$input = "";
        $result = ObtainArray($input);

        return $this->assertEquals(true, $result);
    }
}