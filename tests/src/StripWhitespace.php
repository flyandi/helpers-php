<?php
/**
 * flyandi:php-helper
 *
 * Test for function StripWhitespace
 */

use PHPUnit_Framework_TestCase;

class StripWhitespaceTests extends PHPUnit_Framework_TestCase {

    public function testStripWhitespace() { 
        	$source = "";
	//$stripbreaklines = "";
	//$stripcomments = "";
        $result = StripWhitespace($source, /*$stripbreaklines*/, /*$stripcomments*/);

        return $this->assertEquals(true, $result);
    }
}