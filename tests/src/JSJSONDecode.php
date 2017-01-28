<?php
/**
 * flyandi:php-helper
 *
 * Test for function JSJSONDecode
 */

use PHPUnit_Framework_TestCase;

class JSJSONDecodeTests extends PHPUnit_Framework_TestCase {

    public function testJSJSONDecode() { 
        	$json = "";
	//$assoc = "";
        $result = JSJSONDecode($json, /*$assoc*/);

        return $this->assertEquals(true, $result);
    }
}