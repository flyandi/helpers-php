<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetVarStack
 */

use PHPUnit_Framework_TestCase;

class GetVarStackTests extends PHPUnit_Framework_TestCase {

    public function testGetVarStack() { 
        
        $result = GetVarStack();

        return $this->assertEquals(true, $result);
    }
}