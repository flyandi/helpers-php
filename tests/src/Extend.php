<?php
/**
 * flyandi:php-helper
 *
 * Test for function Extend
 */

use PHPUnit_Framework_TestCase;

class ExtendTests extends PHPUnit_Framework_TestCase {

    public function testExtend() { 
        
        $result = Extend();

        return $this->assertEquals(true, $result);
    }
}