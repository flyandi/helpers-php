<?php
/**
 * flyandi:php-helper
 *
 * Test for function TranslateArray
 */

use PHPUnit_Framework_TestCase;

class TranslateArrayTests extends PHPUnit_Framework_TestCase {

    public function testTranslateArray() { 
        	$array = "";
	$keyMap = "";
	//$includeOriginal = "";
        $result = TranslateArray($array, $keyMap, /*$includeOriginal*/);

        return $this->assertEquals(true, $result);
    }
}