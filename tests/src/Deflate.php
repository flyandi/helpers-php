<?php
/**
 * flyandi:php-helper
 *
 * Test for function Deflate
 */

use PHPUnit_Framework_TestCase;

class DeflateTests extends PHPUnit_Framework_TestCase {

    public function testDeflate() { 
        	$o = "";
        $result = Deflate($o);

        return $this->assertEquals(true, $result);
    }
}