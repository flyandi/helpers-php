<?php
/**
 * flyandi:php-helper
 *
 * Test for function Guid
 */

use PHPUnit_Framework_TestCase;

class GuidTests extends PHPUnit_Framework_TestCase {

    public function testGuid() { 
        	//$length = "";
        $result = Guid(/*$length*/);

        return $this->assertEquals(true, $result);
    }
}