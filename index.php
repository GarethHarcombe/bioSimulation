<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta  http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<title>Biology Simulation</title>
    </head>
    <body onload="startGame()">
		<div class="wrapper">
			<section class="top_container">
				<div id="simulation"></div>
			
				<div class="pause_play">
					<button id="pausePlayButton" type="button">Pause</button>
					Speed
					<input type="range" min="4" max="100" value="20" class="slider" id="sim_speed_slider">
					<span id="sim_speed_value"></span>
				</div>

				<div class="form_container">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
						<input type="hidden" name="mutations" value="false"/>
						<p>Mutations?</p><input type="checkbox" id="mutations_checkbox" name="mutations" value="true"/>
						<br>
					
						<input type="hidden" name="mutations_speed" value="false"/>
						Speed? <input type="checkbox" id="mutations_speed_checkbox" name="mutations_speed" value="true"/>
						<br>
					
						<input type="hidden" name="mutations_sense" value="false"/>
						Sense? <input type="checkbox" id="mutations_sense_checkbox" name="mutations_sense" value="true"/>
						<br>
					
						<input type="hidden" name="mutations_size" value="false"/>
						Size? <input type="checkbox" id="mutations_size_checkbox" name="mutations_size" value="true"/>
						<br>
					
						<input type="hidden" name="kinetic_energy" value="false"/>
						Kinetic Energy? <input type="checkbox" id="kinetic_checkbox" name="kinetic_energy" value="true"/>
						<br>
					
						<input type="hidden" name="predation" value="false"/>
						Predation? <input type="checkbox" id="predation_checkbox" name="predation" value="true"/>
						<br>
					
						<input type="hidden" name="speed" id="speed_hidden" value="20"/>
						<input type="hidden" name="spawn" id="spawn_hidden" value="10"/>
						<input type="hidden" name="nutrition" id="nutrition_hidden" value="100"/>

						<input type="submit">
					</form>
				</div>

				<div class="slide_container">
					Food Spawn
					<input type="range" min="1" max="50" value="5" class="slider" id="food_spawn_slider">
					<span id="food_spawn_value"></span>
					<br>

					Food Nutrition
					<input type="range" min="20" max="600" value="100" class="slider" id="food_value_slider">
					<span id="food_value_value"></span>
				</div>

				<div class="information_container">
					Current Population: <span id="population_value"></span><br>
					Average Population Speed: <span id="average_speed_value"></span><br>
					Average Sense Radius: <span id="average_sense_value"></span><br>
					Average Size: <span id="average_size_value"></span>
				</div>
			</section>

			<section class="bottom_container">
				<div class="chart overall_chart_container">
					<canvas id="overall_chart"></canvas>
				</div>

				<div class="chart mutations_chart_container">
					<canvas id="mutations_chart"></canvas>
				</div>
			</section>

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