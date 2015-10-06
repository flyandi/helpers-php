<?php

include("../src/helpers.php");

$name = "";
//$default = "";

$result = GetHTTPHeaderVar($name, /*$default*/);

var_dump($result);