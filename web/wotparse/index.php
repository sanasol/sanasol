<?php
	
	function getXMLByDataHTML($data)
	{
		if(!empty($data))
		{
			$doc = new DOMDocument();
			$doc->strictErrorChecking = FALSE;
			@$doc->loadHTML('<?xml version="1.0" encoding="UTF-8"?>' .$data);
			$xml = simplexml_import_dom($doc);
			return $xml;
		}
		else
		{
			return false;
		}
	}
	
	require("MyCurl.class.php");
	require("RollingCurl.class.php");
	require("AngryCurl.class.php");
	
	function nothing($response, $info, $request)
	{
		global $xml,$scrubber_xml;
		
		
		if($info['http_code']!==200)
		{
			AngryCurl::add_debug_msg("->\t".$request->options[CURLOPT_PROXY]."\tFAEL\t".$info['http_code']."\t".$info['total_time']."\t".$info['url']);
			return;
		}else
		{
			$newxml = getXMLByDataHTML( $response );
			if($newxml)
			{
				$search_results = $newxml->xpath( $scrubber_xml->xpath->domain );
				if(!empty($search_results))
				{
					foreach($search_results as $search_result)
					{
						$domain = $search_result->div[0]->span->__toString();
						$rank = explode(" ", $search_result->div[1]->span->attributes()->class->__toString())[1];
						if($rank == "r1" || $rank == "r2")
						{
							file_put_contents("domains.txt", $domain.PHP_EOL, FILE_APPEND);
						}
					}
				}
			}
			AngryCurl::add_debug_msg("->\t".$request->options[CURLOPT_PROXY]."\tOKAY\t".$info['http_code']."\t".$info['total_time']."\t".$info['url']);
			return;
		}
		echo "nothing happens!\n";
	}
	
	$AC = new AngryCurl('nothing');
	$AC->__set('window_size', 20);
	$AC->load_useragent_list('./lib/useragent_list.txt');
	
	$AC->__set('use_proxy_list',false);
	$AC->__set('use_useragent_list',true);
	
	$doc = new DOMDocument();
	$doc->strictErrorChecking = FALSE;
	$doc->load("config.xml");
	$scrubber_xml = simplexml_import_dom($doc);
	
	$xml = new SimpleXMLElement('<xml/>');
	for($i=199;$i<999;$i++)
	{
		$AC->get("https://www.mywot.com/en/scorecard?page=".$i);
	}
	$AC->execute();
?>