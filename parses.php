<?php

require_once("parseChinese.php");

$text = file_get_contents("*.xhtml");

$parsed = parseChinese($text, "mandarin_words.txt");
$count = count($parsed);

$rez = "";

for ($j=0; $j < $count; $j++) {    

	$word = $parsed[$j];
	$rez .= $word . "\r\n";
	$urlencoded_word = urlencode($word);
	
	$pinyin_url = "https://glosbe.com/transliteration/api?from=Han&dest=Latin&text=".$urlencoded_word."&format=json";
	//запросы к API

	$response_pinyin = "";
	$json_pinyin = json_decode($response_pinyin);
	if ($json_pinyin["result"] == "ok") {
		$rez .= $json_pinyin["text"] . "\r\n";
	}
	
	$translate_url = "https://glosbe.com/gapi/translate?from=zho&dest=rus&format=json&phrase=".$urlencoded_word."&pretty=true";	
	//запросы к API

	$response_translate = "";
	$json_translate = json_decode($response_translate);
	if ($json_translate["result"] == "ok") {
		$translation_count = count($json_translate["tuc"]);
		for ($i=0; $i < min($translation_count, 3); $i++) {
			$rez .= $json_translate["tuc"][$i]["phrase"]["text"] . "\r\n";
		}	
	}

	$rez .= "\r\n";

}

//Записть результата в файл (промежуточный рез.)
$file = "result.txt";
fopen($file, "w");
file_put_contents($file, $rez);

?>