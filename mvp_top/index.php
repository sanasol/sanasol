<!DOCTYPE html>
<html lang="en">
	<head>
		<title>МВП ТОП</title>
		<meta charset="utf-8" />
			<style>
			html,body,div
			{
				margin:0;
				padding:0;
				border:0;
				outline:0;
			}
</style>
		<link rel="stylesheet" type="text/css" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" /> 
		<link rel="stylesheet" type="text/css" href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" /> 
	</head>
	<body>
		<div style="margin: auto auto; width: 600px;">
		<?php
			
			$jobs = array(
			0    => 'Novice',
			1    => 'Swordsman',
			2    => 'Mage',
			3    => 'Archer',
			4    => 'Acolyte',
			5    => 'Merchant',
			6    => 'Thief',
			7    => 'Knight',
			8    => 'Priest',
			9    => 'Wizard',
			10   => 'Blacksmith',
			11   => 'Hunter',
			12   => 'Assassin',
			14   => 'Crusader',
			15   => 'Monk',
			16   => 'Sage',
			17   => 'Rogue',
			18   => 'Alchemist',
			19   => 'Bard',
			20   => 'Dancer',
			22   => 'Wedding',
			23   => 'Super Novice',
			24   => 'Gunslinger',
			25   => 'Ninja',
			26   => 'Xmas',
			27   => 'Summer',
			
			4001 => 'High Novice',
			4002 => 'High Swordsman',
			4003 => 'High Mage',
			4004 => 'High Archer',
			4005 => 'High Acolyte',
			4006 => 'High Merchant',
			4007 => 'High Thief',
			4008 => 'Lord Knight',
			4009 => 'High Priest',
			4010 => 'High Wizard',
			4011 => 'Whitesmith',
			4012 => 'Sniper',
			4013 => 'Assassin Cross',
			4015 => 'Paladin',
			4016 => 'Champion',
			4017 => 'Professor',
			4018 => 'Stalker',
			4019 => 'Creator',
			4020 => 'Clown',
			4021 => 'Gypsy',
			
			4023 => 'Baby',
			4024 => 'Baby Swordsman',
			4025 => 'Baby Mage',
			4026 => 'Baby Archer',
			4027 => 'Baby Acolyte',
			4028 => 'Baby Merchant',
			4029 => 'Baby Thief',
			4030 => 'Baby Knight',
			4031 => 'Baby Priest',
			4032 => 'Baby Wizard',
			4033 => 'Baby Blacksmith',
			4034 => 'Baby Hunter',
			4035 => 'Baby Assassin',
			4037 => 'Baby Crusader',
			4038 => 'Baby Monk',
			4039 => 'Baby Sage',
			4040 => 'Baby Rogue',
			4041 => 'Baby Alchemist',
			4042 => 'Baby Bard',
			4043 => 'Baby Dancer',
			4045 => 'Super Baby',
			
			4046 => 'Taekwon',
			4047 => 'Star Gladiator',
			4049 => 'Soul Linker',
			
			4054 => 'Rune Knight',
			4055 => 'Warlock',
			4056 => 'Ranger',
			4057 => 'Arch Bishop',
			4058 => 'Mechanic',
			4059 => 'Guillotine Cross',
			4060 => 'Rune Knight T',
			4061 => 'Warlock T',
			4062 => 'Ranger T',
			4063 => 'Arch Bishop T',
			4064 => 'Mechanic T',
			4065 => 'Guillotine Cross T',
			4066 => 'Royal Guard',
			4067 => 'Sorceror',
			4068 => 'Minstrel',
			4069 => 'Wanderer',
			4070 => 'Sura',
			4071 => 'Genetic',
			4072 => 'Shadow Chaser',
			4073 => 'Royal Guard T',
			4074 => 'Sorceror T',
			4075 => 'Minstrel T',
			4076 => 'Wanderer T',
			4077 => 'Sura T',
			4078 => 'Genetic T',
			4079 => 'Shadow Chaser T'
			);
			
			$connection = mysql_connect("localhost", "root", "") or die("Ошибка подключения к БД");
			mysql_select_db("san", $connection) or die("Ошибка выбора БД");
			
			mysql_query("SET CHARACTER SET 'utf8'");
			
			$total_mvp_count_query = mysql_query("select * from mvplog");
			$total_mvp_killed = mysql_num_rows($total_mvp_count_query);
			echo "
			<button class=\"btn btn-large btn-block\" type=\"button\">Всего МвП убито: ".number_format($total_mvp_killed, 0, ',', ' ')."</button>
			";
			
			$result = mysql_query("
			SELECT 
				`char`.name, 
				`char`.class,
				count(3)
			FROM
				`mvplog`
			inner join `char` ON `char`.char_id = `mvplog`.kill_char_id 
			left join login ON `login`.account_id =`char`.account_id
			WHERE 
				`login`.level <= 0
			group by `mvplog`.kill_char_id
			order by count(*)
			desc 
			limit 10
			");
			
			
			echo "
			<table class=\"table table-striped\">
			<thead>
			<tr>
			<th>#</th>
			<th>Имя</th>
			<th>Профессия</th>
			<th>МвП</th>
			</tr>
			</thead>
			";
			
			$nusers = 0;
			if ($result) {
				while ($line = mysql_fetch_row($result)) {
					$nusers++;
					
					echo "    
					<tr>
					<td>{$nusers}</td>
					<td>{$line[0]}</td>
					<td>{$jobs[$line[1]]}</td>
					<td>{$line[2]}</td>
					</tr>
					";
				}
			}
			echo "</table>";
			
		?>
		</div>
	</body>
</html>