<?php   
session_start();
#error_reporting(E_ALL & ~E_NOTICE);  
error_reporting(0);

stream_context_set_default( [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

$exp = 'Category:';  
if(!$a = $_GET['a']) $a = 'Vehicles_by_brand';  
$url = 'https://en.wikipedia.org/w/index.php?title=Special:RandomInCategory/';   
//echo '<pre>';  
$j = $i = 1;  
$urls =  $url.$a;  
while($i == 1 && $j < 5){  
    $head = get_headers($urls,1);  
    $headl = $head['Location'];  
    //echo $head['Location']. " | i:$i j:$j | ";  
    if(!strpos($headl,$exp)) $i = 2;  
    $j++;  
    $urls = $url.end(explode($exp,$headl));  
    //echo " $urls<hr / >";   
}  
#echo $headl;
session_destroy();
if($j < 5){  
    header("location: $headl");  
}  

end();  
?>
