<?php
/**
 * flyandi:php-helper
 *
 * Test for function ChangeArrayKeyCase
 */

use PHPUnit_Framework_TestCase;

class ChangeArrayKeyCaseTests extends PHPUnit_Framework_TestCase {

    public function testChangeArrayKeyCase() { 
        	$input = "";
	//$case = "";
        $result = ChangeArrayKeyCase($input, /*$case*/);

        return $this->assertEquals(true, $result);
    }
}