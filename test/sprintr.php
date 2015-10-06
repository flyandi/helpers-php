<?php

include("../src/helpers.php");


$result = sprintr("Hello {0} {1}! The {0} is wonderful.", "World", "!");

var_dump($result);