<?php 
	
	class ragnarok {
		
		private	$j_names = array(
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
		
		function __construct() {
			//echo "<pre>Объект Ragnarok создан</pre>";
		}
		
		public function get_class($class = 0) {
			return $this->j_names[$class];
		}
		
		public function get_guild($gid = 0) {
			global $mysql_ro;
			if($gid >= 1) {
			$name = iconv("cp1251", "utf-8", mysql_fetch_row(mysql_query("select `name` from z`guild` where `guild_id`={$gid}", $mysql_ro)));
			$this->get_guild_emblem($gid);
			return "<img src='./guilds/{$gid}.png' title='{$name}' width='24'>";
			} else {
			return "<img src='./guilds/no_g.png' width='24'>";
			}
		}
		
		public function get_guild_name($gid = 0) {
			global $mysql_ro;
			if($gid >= 1) {
			$name = mysql_fetch_row(mysql_query("select `name` from `guild` where `guild_id`={$gid}", $mysql_ro));
			return $name[0];
			} else {
			return "-";
			}
		}
		
		private function imagecreatefrombmpstring($im) {
			$header = unpack("vtype/Vsize/v2reserved/Voffset", substr($im,0,14));
			$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant", substr($im,14,40));
			
			extract($info);
			extract($header);
			
			if($type != 0x4D42) return false;
			
			$palette_size = $offset - 54;
			
			$ncolor = $palette_size / 4;									
			
			
			$imres=imagecreatetruecolor($width,$height);
			imagealphablending($imres,false);
			imagesavealpha($imres,true);
			$pal=array();
			
			if($palette_size) {
				$palette = substr($im, 54, $palette_size);
				$gd_palette = "";
				$j = 0; $n=0;
				while($j < $palette_size) {
					$b = ord($palette{$j++});
					$g = ord($palette{$j++});
					$r = ord($palette{$j++});
					$a = ord($palette{$j++});
					if ( ($r==255) && ($g==0) && ($b==255)) $a=127; // alpha = 255 on 0xFF00FF
					$pal[$n++]=imagecolorallocatealpha($imres, $r, $g, $b, $a);
				}
			}
			
			$scan_line_size = (($bits * $width) + 7) >> 3;
			$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03): 0;
			
			for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
				// BMP stores scan lines starting from bottom
				$scan_line = substr($im, $offset + (($scan_line_size + $scan_line_align) * $l), $scan_line_size);
				if($bits == 24) {
					$j = 0; $n=0;
					while($j < $scan_line_size) {
						$b = ord($scan_line{$j++});
						$g = ord($scan_line{$j++});
						$r = ord($scan_line{$j++});
						$a = 0;
						if ( ($r==255) && ($g==0) && ($b==255)) $a=127; // alpha = 255 on 0xFF00FF
						$col=imagecolorallocatealpha($imres, $r, $g, $b, $a);
						imagesetpixel($imres, $n++, $i, $col);
					}
				}
				else if($bits == 8) {
					$j=0;
					while($j<$scan_line_size) {
						$col=$pal[ord($scan_line{$j++})];
						imagesetpixel($imres, $j-1, $i, $col);
					}
				}
				else if($bits == 4) {
					$j = 0; $n=0;
					while($j < $scan_line_size) {
						$byte = ord($scan_line{$j++});
						$p1 = $byte >> 4;
						$p2 = $byte & 0x0F;
						imagesetpixel($imres, $n++, $i, $pal[$p1]);
						imagesetpixel($imres, $n++, $i, $pal[$p2]);
					}
				}
				else if($bits == 1) {
					$j = 0; $n=0;
					while($j < $scan_line_size) {
						$byte = ord($scan_line{$j++});
						$p1 = (int) (($byte & 0x80) != 0);
						$p2 = (int) (($byte & 0x40) != 0);
						$p3 = (int) (($byte & 0x20) != 0);
						$p4 = (int) (($byte & 0x10) != 0);
						$p5 = (int) (($byte & 0x08) != 0);
						$p6 = (int) (($byte & 0x04) != 0);
						$p7 = (int) (($byte & 0x02) != 0);
						$p8 = (int) (($byte & 0x01) != 0);
						imagesetpixel($imres, $n++, $i, $pal[$p1]);
						imagesetpixel($imres, $n++, $i, $pal[$p2]);
						imagesetpixel($imres, $n++, $i, $pal[$p3]);
						imagesetpixel($imres, $n++, $i, $pal[$p4]);
						imagesetpixel($imres, $n++, $i, $pal[$p5]);
						imagesetpixel($imres, $n++, $i, $pal[$p6]);
						imagesetpixel($imres, $n++, $i, $pal[$p7]);
						imagesetpixel($imres, $n++, $i, $pal[$p8]);
					}
				}
			}
			return $imres;
		}
		
		private function get_guild_emblem($gid=0) {
			global $mysql_ro;
			if(!file_exists("./guilds/{$gid}.png") || ($_SERVER['REQUEST_TIME'] - 3600) > filemtime("./guilds/{$gid}.png")) {
				$query_emblem = mysql_fetch_row(mysql_query("SELECT `emblem_data` FROM  guild WHERE `guild_id` = '".$gid."';", $mysql_ro));
				if($query_emblem != 0)
				{
					$query_emblem = gzuncompress(pack('H*',$query_emblem[0]));
					$im = $this->imagecreatefrombmpstring($query_emblem);
					imagepng($im, "./guilds/{$gid}.png");
				} else 
				{
					$im = imagecreate(24, 24);
					$background_color = imagecolorallocatealpha($im, 255, 0, 255,127);
					imagecolortransparent($im, $background_color);
					imagepng($im, "./guilds/{$gid}.png");
				}
			}
		}
	}
	
?>
