<?php
/**
 * flyandi:php-helper
 *
 * Test for function SubstractString
 */

use PHPUnit_Framework_TestCase;

class SubstractStringTests extends PHPUnit_Framework_TestCase {

    public function testSubstractString() { 
        	$source = "";
	$part = "";
        $result = SubstractString($source, $part);

        return $this->assertEquals(true, $result);
    }
}