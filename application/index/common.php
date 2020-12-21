<?php

function high_lighting($str){

    $reg=$GLOBALS['title'];
    $strpre="'".$str."'";
    $exp0="var str = ".$strpre.";";
    $exp1="function HightLight(e){var reg = new RegExp(e, 'g');";
    $exp2="str = str.replace(reg, function(v){return v.fontcolor('Red')});}";
    $exp3="HightLight('".$reg."');";
    $exp4="document.write(str);";
    $exp="<script>".$exp0.$exp1.$exp2.$exp3.$exp4."</script>";
    return $exp;
}

