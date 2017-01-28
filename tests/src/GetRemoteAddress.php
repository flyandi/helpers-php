<?php
/**
 * flyandi:php-helper
 *
 * Test for function GetRemoteAddress
 */

use PHPUnit_Framework_TestCase;

class GetRemoteAddressTests extends PHPUnit_Framework_TestCase {

    public function testGetRemoteAddress() { 
        
        $result = GetRemoteAddress();

        return $this->assertEquals(true, $result);
    }
}