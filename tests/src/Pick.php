<?php
/**
 * flyandi:php-helper
 *
 * Test for function Pick
 */

use PHPUnit_Framework_TestCase;

class PickTests extends PHPUnit_Framework_TestCase {

    public function testPick() { 
        	$array = "";
	$fields = "";
        $result = Pick($array, $fields);

        return $this->assertEquals(true, $result);
    }
}