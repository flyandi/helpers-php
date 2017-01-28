<?php
/**
 * flyandi:php-helper
 *
 * Test for function TrimArray
 */

use PHPUnit_Framework_TestCase;

class TrimArrayTests extends PHPUnit_Framework_TestCase {

    public function testTrimArray() { 
        	$array = "";
        $result = TrimArray($array);

        return $this->assertEquals(true, $result);
    }
}