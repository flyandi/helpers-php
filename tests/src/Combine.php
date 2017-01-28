<?php
/**
 * flyandi:php-helper
 *
 * Test for function Combine
 */

use PHPUnit_Framework_TestCase;

class CombineTests extends PHPUnit_Framework_TestCase {

    public function testCombine() { 
        
        $result = Combine();

        return $this->assertEquals(true, $result);
    }
}