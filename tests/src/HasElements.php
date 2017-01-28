<?php
/**
 * flyandi:php-helper
 *
 * Test for function HasElements
 */

use PHPUnit_Framework_TestCase;

class HasElementsTests extends PHPUnit_Framework_TestCase {

    public function testHasElements() { 
        	$array = "";
	$elements = "";
	//$match = "";
	//$noempty = "";
        $result = HasElements($array, $elements, /*$match*/, /*$noempty*/);

        return $this->assertEquals(true, $result);
    }
}