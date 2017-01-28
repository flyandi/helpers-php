<?php
/**
 * flyandi:php-helper
 *
 * Test for function Compare
 */

use PHPUnit_Framework_TestCase;

class CompareTests extends PHPUnit_Framework_TestCase {

    public function testCompare() { 
        	$a = "";
	$b = "";
	//$strict = "";
        $result = Compare($a, $b, /*$strict*/);

        return $this->assertEquals(true, $result);
    }
}