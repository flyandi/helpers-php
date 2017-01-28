<?php

include("src/helpers.php");


foreach(get_defined_functions()["user"] as $fn) {

	$__fn = new ReflectionFunction($fn);

	$output = array();
	$attributes = array();

	$name = $__fn->getName();
	$params = $__fn->getParameters();
	$paramcount = $__fn->getNumberOfParameters();
	$paramrequired = $__fn->getNumberOfRequiredParameters();

	// create output
	foreach($params as $index => $param) {

		$optional = $index >= $paramrequired;

		$value = "";

		$output[] =  "\t" . ($optional  ? "//" : "") . "$" . $param->name . " = \"" . $value ."\";";

		$attributes[] = ($optional ? "/*" : "") . "$" . $param->name . ($optional ? "*/" : "");

	}

	$fn = "tests/src/" . $name . ".php";

	if(!file_exists($fn))
		file_put_contents($fn, sprintr("<?php
/**
 * flyandi:php-helper
 *
 * Test for function {0}
 */

use PHPUnit_Framework_TestCase;

class {0}Tests extends PHPUnit_Framework_TestCase {

    public function test{0}() { 
        {1}
        \$result = {0}({2});

        return \$this->assertEquals(true, \$result);
    }
}",
    $name,
    implode("\n", $output),
    implode(", ", $attributes)
));
}