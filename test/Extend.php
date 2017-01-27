<?php

include("../src/helpers.php");


var_dump(Extend([], ["bla"], ["foo"]));

var_dump(Extend([], ["key" => "value", "bar" => "foo"]));



var_dump(Extend([], (object) ["key" => "value", "bar" => "foo"]));


class TestClass {

    public function foo() {
        return "bar";
    }
}

var_dump(Extend([], (object) ["key" => "value", "bar" => "foo"], new TestClass()));


