<?php

require_once("parseChinese.php");

$text = file_get_contents("*.xhtml");

$parsed = parseChinese($text, "mandarin_words.txt");

//rewrite
$file = "result.txt";
//Проверить будет ли тут перезапись
fopen($file, "w");
$result = file_get_contents($file);

$count = count($parsed);
for ($i=0; $i < $count; $i++) {    
    $result .= $parsed[$i] . "\r\n";
}

file_put_contents($file, $result);

?>