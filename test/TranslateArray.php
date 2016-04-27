<?php

include("../src/helpers.php");

$array = "";
$keyMap = "";
//$includeOriginal = "";

$result = TranslateArray($array, $keyMap, /*$includeOriginal*/);

var_dump($result);