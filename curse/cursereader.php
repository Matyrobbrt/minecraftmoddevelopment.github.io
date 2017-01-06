<?php
include 'html_dom.php';
$html = file_get_html('https://minecraft.curseforge.com/projects/'.$_GET['c']);
$json = array();
$arz=$html->find('div.info-data');
$json['download']=(string)str_replace(array(",","\n"), "", $arz[2]->plaintext);
$json['created']=$arz[0]->plaintext;
$json['updated']=$arz[1]->plaintext;
$json['name']=(string)$html->find('span.overflow-tip')[0];
$categories = array();
$i = 0;
foreach($html->find('a.e-avatar32') as $element) {
	$categories[$i]=(string)$element->title;
    $i++;
}
$authors = array();
$i = 0;
foreach($html->find('div.avatar-wrapper') as $element) {
	if($i==0) {
		$i++;
		continue;
	}
	$authors[(string)explode(" - ",$element->title)[0]]=(string)explode(" - ",$element->title)[1];
    $i++;
}
$json['categories']=$categories;
$json['authors']=$authors;
$json['desc']=$html->find('meta[property=og:description]')[0]->content;
$json['icon']=$html->find('a.lightbox')[0]->href;
echo str_replace(array("<\/div>","<\/span>",'<span class=\"overflow-tip\">','<div class=\"info-data\">'),"",json_encode($json,JSON_PRETTY_PRINT));