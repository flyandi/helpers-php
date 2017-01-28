<?php
/**
 * flyandi:php-helper
 *
 * Test for function StringArray
 */

use PHPUnit_Framework_TestCase;

class StringArrayTests extends PHPUnit_Framework_TestCase {

    public function testStringArray() { 
        	$input = "";
	//$pairlimiter = "";
	//$valuelimiter = "";
        $result = StringArray($input, /*$pairlimiter*/, /*$valuelimiter*/);

        return $this->assertEquals(true, $result);
    }
}