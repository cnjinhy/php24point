<?php

/**
 * 24点游戏PHP版本，计算任意四个数字通过何种运算法则得到24
 * 24 point calculation
 * run calc(3, 3, 8, 8);
 * you will get:
 * 1:8/(3-8/3)=24
 * 2:8/(3-(8/3))=24
 * @author jinhongyu<jinhongyu@vip.qq.com>
 * @time 2008-12-13 0:24:56
 */
$count = 0;

function add($string, $num) {
    global $str_r;
    global $count;
    $action = 24;
    $afterAdd = "";
    $stra = $string;
    $op1 = $stra[1];
    $op2 = $stra[3];
    $op3 = $stra[5];
    $A = $stra[0];
    $B = $stra[2];
    $C = $stra[4];
    $D = $stra[6];
    if ($num == 0) {
        $afterAdd = "(" . $A . $op1 . $B . ")" . $op2 . $C . $op3 . $D;
    }
    if ($num == 1) {
        $afterAdd = "(" . $A . $op1 . $B . $op2 . $C . ")" . $op3 . $D;
    }
    if ($num == 2) {
        $afterAdd = $A . $op1 . "(" . $B . $op2 . $C . ")" . $op3 . $D;
    }
    if ($num == 3) {
        $afterAdd = $A . $op1 . "(" . $B . $op2 . $C . $op3 . $D . ")";
    }
    if ($num == 4) {
        $afterAdd = $A . $op1 . $B . $op2 . "(" . $C . $op3 . $D . ")";
    }
    if ($num == 5) {
        $afterAdd = $string;
    }
    if ($num == 6) {
        $afterAdd = "(" . $A . $op1 . $B . ")" . $op2 . "(" . $C . $op3 . $D . ")";
    }
    if ($num == 7) {
        $afterAdd = $A . $op1 . "(" . $B . $op2 . "(" . $C . $op3 . $D . "))";
    }
    if ($num == 8) {
        $afterAdd = $A . $op1 . "((" . $B . $op2 . $C . ")" . $op3 . $D . ")";
    }
    if ($num == 9) {
        $afterAdd = "((" . $A . $op1 . $B . ")" . $op2 . $C . ")" . $op3 . $D;
    }
    if ($num == 10) {
        $afterAdd = "(" . $A . $op1 . "(" . $B . $op2 . $C . "))" . $op3 . $D;
    }
    @eval('$return=' . $afterAdd . ';'); //去除除数为0的错误警告
    settype($return, "string");
    settype($action, "string");
    if ($return == $action) {
        $str_r.=$afterAdd . "=24" . "||";
        $count = 1;
    }
}

function calc($a, $b, $c, $d) {
    global $str_r;
    global $count;
    if (empty($a) || empty($b) || empty($c) || empty($d)) {
        return false;
    }
    if (!is_numeric($a) || !is_numeric($b) || !is_numeric($c) || !is_numeric($d)) {
        return false;
    }
    if ($a >= 10 || $b >= 10 || $c >= 10 || $d >= 10 || $a <= 0 || $b <= 0 || $c <= 0 || $d <= 0) {
        return false;
    }
    $array = array($a, $b, $c, $d);    //定义数组
    $op = array("+", "-", "*", "/");  //定义操作符数组
    for ($i = 0; $i < 4; $i++) {
        $a = $array[$i];
        array_splice($array, $i, 1);  //去除数组元素a,索引值不变
        $array1 = $array;
        for ($j = 0; $j < 3; $j++) {
            $b = $array[$j];
            array_splice($array, $j, 1); //去除数组元素b,索引值不变
            $array2 = $array;
            for ($h = 0; $h < 2; $h++) {
                $c = $array[$h];
                array_splice($array, $h, 1); //去除数组元素c ,索引值不变
                $array3 = $array;
                for ($r = 0; $r < 1; $r++) {
                    $d = $array[$r];
                    array_splice($array, $r, 1); //去除清空数组
                    for ($u = 0; $u < 4; $u++) { //插入运算符
                        $op1 = $op[$u];
                        for ($t = 0; $t < 4; $t++) {
                            $op2 = $op[$t];
                            for ($e = 0; $e < 4; $e++) {
                                $op3 = $op[$e];
                                $string = $a . $op1 . $b . $op2 . $c . $op3 . $d;
                                for ($ad = 0; $ad < 11; $ad++) {
                                    $returnString = add($string, $ad);
                                }
                            }
                        }
                    }
                }
                $array = $array2;
            }
            $array = $array1;
        }
        $array = array($a, $b, $c, $d);
    }

    if ($count != 1) {
        echo 'The number you entered(' . $a . ',' . $b . ',' . $c . ',' . $d . ') does not calculate any results';
        return false;
    }

    $array_r = explode("||", $str_r);
    $array_u = array_filter(array_unique($array_r)); //去除数组中重复的值
    $length = count($array_u);
    echo 'There are ' . $length . ' calculation methods by (' . $a . ',' . $b . ',' . $c . ',' . $d . '):';
    echo PHP_EOL;
    $kIndex = 1;
    foreach ($array_u as $value) {
        echo $kIndex . ':' . $value;
        echo PHP_EOL;
        $kIndex++;
    }

    $count = 0;
    $str_r = '';
}
