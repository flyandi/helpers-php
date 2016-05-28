<?php

include("../src/helpers.php");

$string = "Testing removal of this {this} and {that}";
//$st = "";
//$et = "";

$result = ResetVariableString($string);

var_dump($result);