<?php
/**
 * flyandi:php-helper
 *
 * Test for function IsLowerCase
 */

use PHPUnit_Framework_TestCase;

class IsLowerCaseTests extends PHPUnit_Framework_TestCase {

    public function testIsLowerCase() { 
        	$s = "";
        $result = IsLowerCase($s);

        return $this->assertEquals(true, $result);
    }
}