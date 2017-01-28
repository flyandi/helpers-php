<?php
/**
 * flyandi:php-helper
 *
 * Test for function Tag
 */

use PHPUnit_Framework_TestCase;

class TagTests extends PHPUnit_Framework_TestCase {

    public function testTag() { 
        	$tag = "";
	//$attributes = "";
	//$content = "";
        $result = Tag($tag, /*$attributes*/, /*$content*/);

        return $this->assertEquals(true, $result);
    }
}