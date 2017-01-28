<?php
/**
 * flyandi:php-helper
 *
 * Test for function TraverseArray
 */

use PHPUnit_Framework_TestCase;

class TraverseArrayTests extends PHPUnit_Framework_TestCase {

    public function testTraverseArray() { 
        	$input = "";
	$handler = "";
        $result = TraverseArray($input, $handler);

        return $this->assertEquals(true, $result);
    }
}