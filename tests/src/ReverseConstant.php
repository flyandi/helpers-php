<?php
/**
 * flyandi:php-helper
 *
 * Test for function ReverseConstant
 */

use PHPUnit_Framework_TestCase;

class ReverseConstantTests extends PHPUnit_Framework_TestCase {

    public function testReverseConstant() { 
        	$source = "";
	//$value = "";
        $result = ReverseConstant($source, /*$value*/);

        return $this->assertEquals(true, $result);
    }
}