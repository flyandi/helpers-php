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

		$output[] =  ($optional  ? "//" : "") . "$" . $param->name . " = \"" . $value ."\";";

		$attributes[] = ($optional ? "/*" : "") . "$" . $param->name . ($optional ? "*/" : "");

	}
	$output[] = "";

	$output[] = "\$result = " . $name ."(" . implode(", ", $attributes) . ");";

	file_put_contents("test/" . $name . ".php", sprintf("<?php\n\ninclude(\"../src/helpers.php\");\n\n%s\n\nvar_dump(\$result);", implode("\n", $output)));
}