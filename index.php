<!DOCTYPE html>
<html>
    <head>
        <title>Biology Simulation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css">
    </head>
    <body onload="startGame()">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

        <button id="pausePlayButton" type="button">Pause</button>
        <input type="range" min="4" max="100" value="20" class="slider" id="sim_speed_slider">
        <p>Speed: <span id="sim_speed_value"></span></p>

        <div style="width:50%;">
            <canvas id="overall_chart"></canvas>
        </div>

        <div style="width:50%;">
            <canvas id="mutations_chart"></canvas>
        </div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
			<input type="hidden" name="mutations" value="false" />
			Mutations? <input type="checkbox" id="mutations_checkbox" name="mutations" value="true"/>
			<input type="hidden" name="kinetic_energy" value="false" />
			Kinetic Energy? <input type="checkbox" id="kinetic_checkbox" name="kinetic_energy" value="true"/>
			<input type="hidden" name="predation" value="false" />
			Predation? <input type="checkbox" id="predation_checkbox" name="predation" value="true"/>
			<input type="submit">
		</form>

        <p>Food Spawn</p>
        <div class="slide_container">
            <input type="range" min="1" max="50" value="5" class="slider" id="food_spawn_slider">
            <p>Food Spawn Rate: <span id="food_spawn_value"></span></p>
        </div>

        <p>Food Nutrition</p>
        <div class="slide_container">
            <input type="range" min="20" max="600" value="100" class="slider" id="food_value_slider">
            <p>Food Nutritional Value: <span id="food_value_value"></span></p>
        </div>

        <div class="current_information_container">
            <p>Current Population: <span id="population_value"></span></p>
            <p>Average Population Speed: <span id="average_speed_value"></span></p>
            <p>Average Sense Radius: <span id="average_sense_value"></span></p>
            <p>Average Size: <span id="average_size_value"></span></p>
        </div>

		<script>
			var mutationsPHP = <?php echo (!empty($_GET['mutations']) ? $_GET['mutations'] : true); ?>;
			var kinetic_energyPHP = <?php echo (!empty($_GET['kinetic_energy']) ? $_GET['kinetic_energy'] : true); ?>;
			var predationPHP = <?php echo (!empty($_GET['predation']) ? $_GET['predation'] : true); ?>;
		</script>
        <script src="app.js"></script>
    </body>
</html>