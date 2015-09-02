<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>WoE Stats Ragnarok Online</title>
		<link rel="stylesheet" type="text/css" href="bbGrid.css">
		<link href="bootstrap.css" rel="stylesheet">
		
        <script type="text/javascript" src="jquery-latest.min.js"></script>	
        <script type="text/javascript" src="underscore-min.js"></script>
        <script type="text/javascript" src="backbone-min.js"></script>
        <script src="bootstrap.min.js"></script>
        <script type="text/javascript" src="bbGrid.js"></script>
		
		
		<script>
			$(function(){
				var App = {};
				App._exampleCollection = Backbone.Collection.extend({
					url: 'rating.php'
				});
				
				App.exampleCollection = new App._exampleCollection();
				
				
				App.exampleCollection.fetch({ wait: true, 
					success:function(collection) {
						
						App.MyGrid = new bbGrid.View({
							container: $('.caont'),     
							rows: 10,
							rowList: [10, 20, 40, 80],
							collection: App.exampleCollection,
							colModel: [
							{ title: 'Name', name: 'name', index: true, filterType: 'input', filter: true },
							{ title: 'Guild',  name: 'guild', filter: true},
							{ title: '',  name: 'guild_emb'},
							{ title: 'Kill Count', name: 'kill_count', sorttype: 'number', index: true},
							{ title: 'Death Count',  name: 'death_count', sorttype: 'number'},
							{ title: 'Level',  name: 'lvl'},
							{ title: 'Class',  name: 'job', filter: true},
							{ title: 'score', name: 'score', sorttype: 'number'},
							{ title: 'top_damage', index: true, name: 'top_damage', sorttype: 'number'},
							{ title: 'damage_done', index: true, name: 'damage_done', sorttype: 'number'},
							{ title: 'damage_received', index: true, name: 'damage_received', sorttype: 'number'},
							{ title: 'emperium_damage', index: true, name: 'emperium_damage', sorttype: 'number'},
							{ title: 'guardian_damage', index: true, name: 'guardian_damage', sorttype: 'number'},
							{ title: 'barricade_damage', index: true, name: 'barricade_damage', sorttype: 'number'},
							{ title: 'gstone_damage', index: true, name: 'gstone_damage', sorttype: 'number'},
							{ title: 'emperium_kill', index: true, name: 'emperium_kill', sorttype: 'number'},
							{ title: 'guardian_kill', index: true, name: 'guardian_kill', sorttype: 'number'},
							{ title: 'barricade_kill', index: true, name: 'barricade_kill', sorttype: 'number'},
							{ title: 'gstone_kill', index: true, name: 'gstone_kill', sorttype: 'number'},
							{ title: 'sp_heal_potions', index: true, name: 'sp_heal_potions', sorttype: 'number'},
							{ title: 'hp_heal_potions', index: true, name: 'hp_heal_potions', sorttype: 'number'},
							{ title: 'yellow_gemstones', index: true, name: 'yellow_gemstones', sorttype: 'number'},
							{ title: 'red_gemstones', index: true, name: 'red_gemstones', sorttype: 'number'},
							{ title: 'blue_gemstones', index: true, name: 'poison_bottles', sorttype: 'number'},
							{ title: 'acid_demostration', index: true, name: 'acid_demostration_fail', sorttype: 'number'},
							{ title: 'healing_done', index: true, name: 'healing_done', sorttype: 'number'},
							{ title: 'wrong_support_skills_used', index: true, name: 'wrong_support_skills_used', sorttype: 'number'},
							{ title: 'support_skills_used', index: true, name: 'support_skills_used', sorttype: 'number'},
							{ title: 'wrong_healing_done', index: true, name: 'wrong_healing_done', sorttype: 'number'},
							{ title: 'sp_used', index: true, name: 'sp_used', sorttype: 'number'},
							{ title: 'zeny_used', index: true, name: 'zeny_used', sorttype: 'number'},
							{ title: 'spiritb_used', index: true, name: 'spiritb_used', sorttype: 'number'},
							{ title: 'ammo_used', index: true, name: 'ammo_used', sorttype: 'number'}
							],
							enableSearch: true
						});
						
					}
				});
			});
		</script>
	</head>
	<body>
		<div class="caont">
		</div>
	</body>
</html>
