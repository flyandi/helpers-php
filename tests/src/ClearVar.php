<?php
/**
 * flyandi:php-helper
 *
 * Test for function ClearVar
 */

use PHPUnit_Framework_TestCase;

class ClearVarTests extends PHPUnit_Framework_TestCase {

    public function testClearVar() { 
        	$name = "";
        $result = ClearVar($name);

        return $this->assertEquals(true, $result);
    }
}