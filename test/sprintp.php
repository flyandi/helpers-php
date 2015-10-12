<?php

include("../src/helpers.php");


$result = sprintp("[{0}]", "Banana", "Apple", "Peach", "Cherry");

var_dump($result);

$result = sprintp("[{0} = {1}]", ["Bananas", "Yummy"], ["Apples", "Good"], ["Peach", "Natural"] );

var_dump($result);


