<?php
/**
 * flyandi:php-helper
 *
 * Test for function sprintr
 */

use PHPUnit_Framework_TestCase;

class sprintrTests extends PHPUnit_Framework_TestCase {

    public function testsprintr() { 
        
        $result = sprintr();

        return $this->assertEquals(true, $result);
    }
}