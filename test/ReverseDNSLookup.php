<?php

include("../src/helpers.php");

$ip = "";

$result = ReverseDNSLookup($ip);

var_dump($result);