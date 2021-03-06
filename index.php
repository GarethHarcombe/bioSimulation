<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta  http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<title>Biology Simulation</title>
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body onload="startGame()">
		<div class="warning">
			<p>Welcome to Biology Simulation!<br>Please turn your phone to landscape mode by turning it sideways</p>
		</div>

		<div class="wrapper">
			<div class="top_container">
				<div class="title_container item">
					<h1>Biology Simulation</h1>
					<div id="HeaderLink"><a href="explanations.php">Biology Explanations</a></div>
				</div>
				
				<div id="simulation" class="item"></div>

				<div class="pause_play item">
					<button id="pause_play_button" type="button">Pause</button>
					Speed
					<input type="range" min="4" max="100" value="20" class="slider" id="sim_speed_slider">
					<span id="sim_speed_value"></span>
					<div id="restart_button"><a href="index.php" onclick="return confirm('This will reset the simulation. Are you sure you want to reload with the basic starting settings?')">Reset Simulation</a></div>
				</div>

				<div class="slide_container item">
					<h2>Live Settings</h2>
					<table>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">The rate at which food spawns</div>
							</td>
							<td>Food Spawn</td>
							<td><input type="range" min="1" max="50" value="5" class="slider" id="food_spawn_slider"></td>
							<td><span id="food_spawn_value"></span></td>
						</tr>

						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">How much nutrition each bit of food gives</div>
							</td>
							<td>Food Nutrition</td>
							<td><input type="range" min="20" max="600" value="100" class="slider" id="food_value_slider"></td>
							<td><span id="food_value_value"></span></td>
						</tr>
					</table>
				</div>

				<div class="information_container item">
					<h2>Simulation Information</h2>
					<table>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">This displays how many organisms are currently alive</div>
							</td>
							<td>Current Population:</td>
							<td><span id="population_value"></span></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">This displays the average movement speed of the population</div>
							</td>
							<td>Average Speed:</td>
							<td><span id="average_speed_value"></span></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">This displays the average distance at which organisms can sense food</div>
							</td>
							<td>Average Sense Radius:</td>
							<td><span id="average_sense_value"></span></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">This displays the average size of the population</div>
							</td>
							<td>Average Size:</td>
							<td><span id="average_size_value"></span></td>
						</tr>
					</table>
				</div>

				<form class="form_container item" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
					<h2>Simulation Settings</h2>
					<table>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want the organisms to mutate?</div>
							</td>
							<td>Mutations?</td>
							<td><input type="hidden" name="mutations" value="false"/>
							<input type="checkbox" id="mutations_checkbox" name="mutations" value="true"/></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want the organism speed to mutate?</div>
							</td>
							<td> - Speed?</td>
							<td><input type="hidden" name="mutations_speed" value="false"/>
							<input type="checkbox" id="mutations_speed_checkbox" name="mutations_speed" value="true"/></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want the organism sense distance to mutate?</div>
							</td>
							<td> - Sense?</td>
							<td><input type="hidden" name="mutations_sense" value="false"/>
							<input type="checkbox" id="mutations_sense_checkbox" name="mutations_sense" value="true"/></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want the organism size to mutate?</div>
							</td>
							<td> - Size?</td>
							<td><input type="hidden" name="mutations_size" value="false"/>
							<input type="checkbox" id="mutations_size_checkbox" name="mutations_size" value="true"/></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want kinetic energy to be factored into the simulation?</div>
							</td>
							<td>Kinetic Energy?</td>
							<td><input type="hidden" name="kinetic_energy" value="false"/>
							<input type="checkbox" id="kinetic_checkbox" name="kinetic_energy" value="true"/></td>
						</tr>
						<tr>
							<td>
								<div class="hint_icon">?</div>
								<div class="hint">Do you want organisms to be able to predate others?</div>
							</td>
							<td>Predation?</td>
							<td><input type="hidden" name="predation" value="false"/>
						<input type="checkbox" id="predation_checkbox" name="predation" value="true"/></td>
						</tr>
					</table>

					<input type="hidden" name="speed" id="speed_hidden" value="20"/>
					<input type="hidden" name="spawn" id="spawn_hidden" value="10"/>
					<input type="hidden" name="nutrition" id="nutrition_hidden" value="100"/>
					<input type="submit" value="Submit and Reload" onclick="return confirm('This will restart the simulation. Are you sure you want to reload with the updated settings?')">
				</form>
			</div>

			<div class="bottom_container">
				<div class="overall_chart_container item">
					<canvas id="overall_chart"></canvas>
				</div>

				<div class="mutations_chart_container item">
					<canvas id="mutations_chart"></canvas>
				</div>
			</div>

			<script>
				var mutationsPHP = <?php echo (!empty($_GET['mutations']) ? $_GET['mutations'] : true); ?>;
				var mutations_speedPHP = <?php echo (!empty($_GET['mutations_speed']) ? $_GET['mutations_speed'] : true); ?>;
				var mutations_sensePHP = <?php echo (!empty($_GET['mutations_sense']) ? $_GET['mutations_sense'] : true); ?>;
				var mutations_sizePHP = <?php echo (!empty($_GET['mutations_size']) ? $_GET['mutations_size'] : true); ?>;

				var kinetic_energyPHP = <?php echo (!empty($_GET['kinetic_energy']) ? $_GET['kinetic_energy'] : true); ?>;
				var predationPHP = <?php echo (!empty($_GET['predation']) ? $_GET['predation'] : true); ?>;

				var speedPHP = <?php echo (!empty($_GET['speed']) ? $_GET['speed'] : 20); ?>;
				var spawnPHP = <?php echo (!empty($_GET['spawn']) ? $_GET['spawn'] : 10); ?>;
				var nutritionPHP = <?php echo (!empty($_GET['nutrition']) ? $_GET['nutrition'] : 100); ?>;
			</script>
			<script src="app.js"></script>
		</div>
    </body>
</html>