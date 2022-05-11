<?php  
error_reporting(E_ALL & ~E_NOTICE); 
error_reporting(0);
$exp = 'Category:'; 
if(!$a = $_GET['a']) $a = 'Vehicles_by_brand'; 
$url = 'https://en.wikipedia.org/w/index.php?title=Special:RandomInCategory/';  
//echo '<pre>'; 
$j = $i = 1; 
$urls =  $url.$a; 
while($i == 1 && $j < 10){ 
    $head = get_headers($urls,1); 
    $headl = $head['Location']; 
    //echo $head['Location']. " | i:$i j:$j | "; 
    if(!strpos($headl,$exp)) $i = 2; 
    $j++; 
    $urls = $url.end(explode($exp,$headl)); 
    //echo " $urls<hr / >";  
} 
if($j < 5){ 
    header("location: $headl"); 
} 
end(); 
?>