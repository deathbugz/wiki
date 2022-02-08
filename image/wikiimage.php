<?php   
error_reporting(E_ALL); 
// Report all PHP errors 
error_reporting(0); 
echo '<pre>';  print_r($_SERVER); 
#exit;
#echo '<pre>';
#print_r( get_loaded_extensions());
#echo '</pre>';   
  
if(!$_GET['q']) { 
	$q = reset(explode('.',trim(next(explode('/',urldecode($_SERVER['REQUEST_URI'])))))); 
	$q0 = explode('.',next(explode('/wikiimage/',trim($_SERVER['SCRIPT_URL']))));
	$q = $q0[0];
	$index = next(explode('-',$q));
	
	if(!$index) { $index = $q0[1]; }
	else{ $q = reset(explode('-',$q));}
	if($index<=0){ $index = 1;}
	$index = $index-1;
	#else{  }
	$q = str_replace('-',' ',$q); 
	$q = str_replace('_',' ',$q);
 #echo "|q: $q| index: $index| q0: ".$q0[0]."|";	
} 
#exit;
#echo $json_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&q=".urlencode(trim($q))."&safeSearch=strict&type=video&videoEmbeddable=true&key=AIzaSyDRA7z0Zddi4y7mEjc81PqhzbmQvS5SFDk";     
#exit;

#if(  strpos( reset(get_headers($json_url, 1) ) ,'200 OK') or 0 ){   
  

 $url = 'https://commons.wikimedia.org/w/index.php?sort=relevance&search='.urlencode(trim($q)).'+filetype%3Abitmap+filew%3A%3E800&title=Special%3ASearch&profile=advanced&fulltext=1&advancedSearch-current=%7B%22fields%22%3A%7B%22filetype%22%3A%22bitmap%22%2C%22filew%22%3A%5B%22%3E%22%2C%22800%22%5D%7D%7D&ns6=1';   
	$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	#$html = file_get_contents($url,true, $context);
	#$xml = simplexml_load_string($html);
	
	#echo $xml->asXML();
    #exit;
	#echo $xml = simplexml_load_file($url);  
    #https://commons.wikimedia.org/w/index.php?sort=relevance&search='.urlencode(trim($q)).'+filetype%3Abitmap+filew%3A%3E800&title=Special%3ASearch&profile=advanced&fulltext=1&advancedSearch-current=%7B%22fields%22%3A%7B%22filetype%22%3A%22bitmap%22%2C%22filew%22%3A%5B%22%3E%22%2C%22800%22%5D%7D%7D&ns6=1 
	
$dom = new DOMDocument;
@$dom->loadHTMLFile($url); 
$html = $dom->saveHTML();
$loop = substr_count($html,'"mw-search-result"');
#exit;

$max = 20;
if($loop>=$max) $loop = $max;

$xpath = new DOMXpath($dom);

$result = array();
for($i = 1;$i<= $loop; $i++){
	$quer = '//ul[@class="mw-search-results"]/li['.$i.']//td[1]//img/@src';
	$elements = $xpath->query($quer);

	foreach($elements as $value) {
		array_push($result, $value->nodeValue); // J244
		#echo $value->nodeValue;
	} 
}

/*
$result = $xml->xpath('//ul[@class="mw-search-results"]/li[1]//td[1]//img/@src');  
$json = json_encode($result);  
echo $result = json_decode($json,TRUE); 
*/ 
$urlx = trim($result[$index]);
$urlx = str_replace('120px','1920px', $urlx);  
$urlx = str_replace('99px','1920px', $urlx);  
$urlx = str_replace('98px','1920px', $urlx); 
$urlx = str_replace('84px','1920px', $urlx);  
$urlx = str_replace('86px','1920px', $urlx);  
$urlx = str_replace('80px','1920px', $urlx);  
$urlx = str_replace('100px','1920px', $urlx); 
#$url = str_replace('https://','https://i0.wp.com/',$urlx);  
#echo '<pre>';  
echo '<textarea>'; echo $url.PHP_EOL; echo $q.PHP_EOL; echo $index.PHP_EOL;echo  $urlx.PHP_EOL;  echo '</textarea>'; 


#exit;

if(count( $result )<1 || !$urlx) { $urlx = 'https://bit.ly/2Y3uqYZ'; }
#echo $urlx;  

header("location: $urlx");    


?>   
