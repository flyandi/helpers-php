<?php

include("../src/helpers.php");

$array = "";
$key = "";
$value = "";
//$returnKey = "";

$result = FromArrayObject($array, $key, $value, /*$returnKey*/);

var_dump($result);