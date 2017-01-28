<?php
/**
 * flyandi:php-helper
 *
 * Test for function Inbetween
 */

use PHPUnit_Framework_TestCase;

class InbetweenTests extends PHPUnit_Framework_TestCase {

    public function testInbetween() { 
        	$string = "";
	$start = "";
	$end = "";
	//$single = "";
        $result = Inbetween($string, $start, $end, /*$single*/);

        return $this->assertEquals(true, $result);
    }
}