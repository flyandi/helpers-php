<?php

include("../src/helpers.php");

$name = "";
$value = "";

$result = SetServerVar($name, $value);

var_dump($result);