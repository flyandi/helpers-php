<?php
/**
 * flyandi:php-helper
 *
 * Test for function aprintp
 */

use PHPUnit_Framework_TestCase;

class aprintpTests extends PHPUnit_Framework_TestCase {

    public function testaprintp() { 
        
        $result = aprintp();

        return $this->assertEquals(true, $result);
    }
}