<?php

include("../src/helpers.php");


$result = Guid();

var_dump($result);

$result = Guid(16);

var_dump($result);