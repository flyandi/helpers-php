<?php
/**
 * flyandi:php-helper
 *
 * Test for function Inflate
 */

use PHPUnit_Framework_TestCase;

class InflateTests extends PHPUnit_Framework_TestCase {

    public function testInflate() { 
        	$o = "";
        $result = Inflate($o);

        return $this->assertEquals(true, $result);
    }
}