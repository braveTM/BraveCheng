<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<pre>";
//print_r($GLOBALS);
interface interOne {

    const constance = "contant value";

    public function fun1();

    public function func2();

    function printr();

    abstract public function getError();
}

class interFrom implements interOne {

    private $error = null;

    function fun1() {
        return self::constance;
    }

    function func2() {
        return;
    }

    function printr($expression) {
        echo "<pre>";
        print_r($expression);
    }

    function getError($error) {
        $this->error = $error;
    }

}

$self = new interFrom();
$self->printr($self);

phpinfo();
