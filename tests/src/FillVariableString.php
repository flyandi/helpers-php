<?php
/**
 * flyandi:php-helper
 *
 * Test for function FillVariableString
 */

use PHPUnit_Framework_TestCase;

class FillVariableStringTests extends PHPUnit_Framework_TestCase {

    public function testFillVariableString() { 
        	$string = "";
	$data = "";
	//$simplematch = "";
	//$st = "";
	//$et = "";
	//$suffix = "";
	//$max = "";
	//$__level = "";
        $result = FillVariableString($string, $data, /*$simplematch*/, /*$st*/, /*$et*/, /*$suffix*/, /*$max*/, /*$__level*/);

        return $this->assertEquals(true, $result);
    }
}