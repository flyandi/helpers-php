<?php

include("../src/helpers.php");


$result = aprintp("[{0}]", "Banana", "Apple", "Peach", "Cherry");

var_dump($result);

$result = aprintp("[{0} = {1}]", ["Bananas", "Yummy"], ["Apples", "Good"], ["Peach", "Natural"] );

var_dump($result);


