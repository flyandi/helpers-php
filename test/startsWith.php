<?php

include("../src/helpers.php");

$haystack = "";
$needle = "";

$result = startsWith($haystack, $needle);

var_dump($result);