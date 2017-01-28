<?php
/**
 * flyandi:php-helper
 *
 * Test for function sprintp
 */

use PHPUnit_Framework_TestCase;

class sprintpTests extends PHPUnit_Framework_TestCase {

    public function testsprintp() { 
        
        $result = sprintp();

        return $this->assertEquals(true, $result);
    }
}