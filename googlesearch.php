<?php 
//-- GOOGLE
$start=0;
$num = 100; 
$search='consultor seo';
$site ='com.br';//com; com.br; com.uk, ...
$ct=1;

if($argc>0){
	$start =  intval($argv[1]);		
} 

if($argc>1){
	$search  =   ' '.$argv[2];		
} 
	

echo ':::START::: '.$start;	
//pagination - limited 10000 links with pages with 100 links each
$ini = $start;
$limit = 10000;

			system("echo \"RESULTS FOR SEARCH '{search}'\" > MATCHES.TXT");

for($start = $ini; $start < $limit ; $start+=100){	
    
		$urlBase = "https://www.google.{$site}/search?q=".urlencode($search)."&num=100&start={$start}&sa=N";

	echo("\r\n".$urlBase."\r\n");
	$google = file_get_contents($urlBase);
	if($start>0)
	{
		preg_match('/id="resultStats".*\s(\d+)/i',$google,$result);
		$limit = intval($result[1]);		
	    echo "Limit detected {$limit}\r\n";
        
	}

	
	$pattern =  "/<a href=\"\\/url\\?q=([^\\&]+)/i";  

	//get urls 
	preg_match_all($pattern, $google, $result);
 
    foreach($result[0] as $bl):
		
	//sample for match in url regex
		preg_match('/(.*\/\/(.*)\/)/i',$bl,$match);

		if($match[1] !=null){
			echo $ct." ";
			system("echo \"{$ct}\"	\"{$match[2]}\"	\"{$search}\" >> MATCHES.TXT");
		}
		$ct++;

	endforeach;
	
	sleep(2);//avoid google blocking
  
 
}
echo "\r\n\r\nEND";

?>
