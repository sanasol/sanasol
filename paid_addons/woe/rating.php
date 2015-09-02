<?php
	
	function write($file, $data)
	{
		$handle = fopen($file, "a+");
		if(fwrite($handle, $data . PHP_EOL))
		{
			fclose($handle);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	if(!file_exists("top.cache") || ($_SERVER['REQUEST_TIME'] - 3600) > filemtime("top.cache")) {
		
		//MySQL host
		$ro['db']['host'] = "localhost";
		//MySQL User
		$ro['db']['user'] = "root";
		//MySQL Password
		$ro['db']['password'] = "";
		//MySQL DB
		$ro['db']['database'] = "san";
		//MySQL Encoding
		$ro['db']['sql_encode'] = "utf8";
		$ro['db']['encode'] = "UTF-8";
		
		if($mysql_ro = mysql_connect($ro['db']['host'],$ro['db']['user'],$ro['db']['password'], true)) 
		{ 
			if(mysql_select_db($ro['db']['database'], $mysql_ro)) 
			{ 
				mysql_query("SET character_set_connection=".$ro['db']['sql_encode']); 
				mysql_query("SET character_set_client=".$ro['db']['sql_encode']); 
				mysql_query("SET character_set_results=".$ro['db']['sql_encode']); 
			} 
		} 
		require("class.ragnarok.php");
		
		$ro_obj = new ragnarok();
		
		$query = mysql_query("select * from `char_wstats`");
		while($row = mysql_fetch_assoc($query))
		{
			foreach($row as $key => $val) { $result_row[$key] = (int)$val; }
			$info = mysql_fetch_assoc(mysql_query("select `name`, `base_level`, `job_level`, `class`, `guild_id` from `char` where `char_id`='{$row["char_id"]}'", $mysql_ro));
			$result_row["name"] = $info["name"];
			$result_row["guild"] = $ro_obj->get_guild_name($info["guild_id"]);
			$result_row["guild_emb"] = $ro_obj->get_guild($info["guild_id"]);
			$result_row["lvl"] = "{$info["base_level"]}/{$info["job_level"]}";
			$result_row["job"] = $ro_obj->get_class($info["class"]);
			$result[] = $result_row;
		}
		unlink("top.cache");
		write("top.cache", json_encode($result));
		echo json_encode($result);
	}
	else
	{
		echo file_get_contents("top.cache");
	}
?>