<?php
/**
 * flyandi:php-helper
 *
 * Test for function startsWith
 */

use PHPUnit_Framework_TestCase;

class startsWithTests extends PHPUnit_Framework_TestCase {

    public function teststartsWith() { 
        	$haystack = "";
	$needle = "";
        $result = startsWith($haystack, $needle);

        return $this->assertEquals(true, $result);
    }
}