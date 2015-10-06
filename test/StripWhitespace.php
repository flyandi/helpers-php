<?php

include("../src/helpers.php");

$source = "";
//$stripbreaklines = "";
//$stripcomments = "";

$result = StripWhitespace($source, /*$stripbreaklines*/, /*$stripcomments*/);

var_dump($result);