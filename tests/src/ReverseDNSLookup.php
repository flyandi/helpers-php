<?php
/**
 * flyandi:php-helper
 *
 * Test for function ReverseDNSLookup
 */

use PHPUnit_Framework_TestCase;

class ReverseDNSLookupTests extends PHPUnit_Framework_TestCase {

    public function testReverseDNSLookup() { 
        	$ip = "";
        $result = ReverseDNSLookup($ip);

        return $this->assertEquals(true, $result);
    }
}