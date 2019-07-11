<!DOCTYPE html>
<html>
    <head>
        <title>Biology Simulation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css">
    </head>
    <body onload="startGame()">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<div>
			<button id="pausePlayButton" type="button">Pause</button>
			Speed
			<input type="range" min="4" max="100" value="20" class="slider" id="sim_speed_slider">
			<span id="sim_speed_value"></span>
		</div>

        <div style="width:50%;">
            <canvas id="overall_chart"></canvas>
        </div>

        <div style="width:50%;">
            <canvas id="mutations_chart"></canvas>
        </div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
			<input type="hidden" name="mutations" value="false"/>
			Mutations? <input type="checkbox" id="mutations_checkbox" name="mutations" value="true"/>

			<input type="hidden" name="mutations_speed" value="false"/>
			Speed? <input type="checkbox" id="mutations_speed_checkbox" name="mutations_speed" value="true"/>

			<input type="hidden" name="mutations_sense" value="false"/>
			Sense? <input type="checkbox" id="mutations_sense_checkbox" name="mutations_sense" value="true"/>

			<input type="hidden" name="mutations_size" value="false"/>
			Size? <input type="checkbox" id="mutations_size_checkbox" name="mutations_size" value="true"/>

			<input type="hidden" name="kinetic_energy" value="false"/>
			Kinetic Energy? <input type="checkbox" id="kinetic_checkbox" name="kinetic_energy" value="true"/>

			<input type="hidden" name="predation" value="false"/>
			Predation? <input type="checkbox" id="predation_checkbox" name="predation" value="true"/>

			<input type="hidden" name="speed" id="speed_hidden" value="20"/>
			<input type="hidden" name="spawn" id="spawn_hidden" value="10"/>
			<input type="hidden" name="nutrition" id="nutrition_hidden" value="100"/>

			<input type="submit">
		</form>

        <p>Food Spawn</p>
        <div class="slide_container">
            <input type="range" min="1" max="50" value="5" class="slider" id="food_spawn_slider">
            <span id="food_spawn_value"></span>
        </div>

        <p>Food Nutrition</p>
        <div class="slide_container">
            <input type="range" min="20" max="600" value="100" class="slider" id="food_value_slider">
            <span id="food_value_value"></span>
        </div>

        <div class="current_information_container">
            <p>Current Population: <span id="population_value"></span></p>
            <p>Average Population Speed: <span id="average_speed_value"></span></p>
            <p>Average Sense Radius: <span id="average_sense_value"></span></p>
            <p>Average Size: <span id="average_size_value"></span></p>
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
    </body>
</html>