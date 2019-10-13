<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<meta  http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
		<title>Biology Explanations</title>
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
		<div class="wrapper">
			<div class="item">
				<h1>Biology Explanations</h1>
				<div id="HeaderLink"><a href="index.php">Biology Simulation</a></div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/StandardSimulation.PNG" alt="A standard simulation">
				</div>
				
				<div class="left">
					<h2>What's going on?</h2>
					The red squares are organisms, going about their lives trying to survive. Simply existing requires energy - each second, every organism will lose energy, with larger and faster organisms using more energy. If they run out of energy, then they will die. Therefore, in order to survive, they must gain energy by eating food - the green squares - or if they are big enough, other organisms! If they gain enough energy to reproduce, they will do so, creating one offspring. However, this offspring has a chance for random mutations to occur, either increasing or decreasing its speed, size and ability to sense food. If this provides an adaptive advantage then the offspring will be more likely to survive and reproduce. Over time, this results in the more favourable traits increasing in frequency.
				</div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/Oscillations.PNG" alt="Graph of Oscillating Values">
				</div>
				
				<div class="left">
					<h2>The current population seems to oscillate between high and low - why?</h2>
					Each environment has a carrying capacity - how many organisms can survive in the environment, based on how much food exists. 
					The organisms will continue to reproduce and eat food until there are more organisms than the environment can carry and all the food is eaten. As a result, there is no food for any of the organisms to eat, resulting in the population numbers plummeting. However, this results in more food being available, as there are fewer organisms eating the food. As a result, the population increases again. This cycle continues many times, resulting in the population varying over time. 
					This can be seen using the food and population chart, where the population numbers will increase and food decrease until eventually the population numbers will plummet. However, this is followed by the food increasing, allowing the population numbers to increase again.
				</div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/SpeedArrows.PNG" alt="Different speed values for organisms">
				</div>

				<div class="left">
					<h2>The speed trait</h2>
					We would typically assume that more speed is advantageous in any organism. However, when running the simulation, the speed does not increase infinitely, it reaches a limit - why? This is because having a high speed requires more energy. Kinetic energy is defined as 0.5 * mass * velocity squared, and so an increasing velocity leads to a dramatically increasing consumption of energy. Speed is still beneficial and necessary in order to reach food before other organisms, but too much speed results in an energy consumption which is too high for the organism to provide, resulting in death. Therefore, a balance is found.
					You can play around with this by disabling kinetic energy. As a result, there is no limit of the maximum speed, leading to the organisms increasing in speed infinitely.
				</div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/SenseDistance.PNG" alt="Different coloured organisms with lighter colours">
				</div>

				<div class="left">
					<h2>The sense trait</h2>
					The sense trait is the distance at which an organism can find and move towards food. Organisms with a higher sense distance will turn a pink colour. This mutation is different from others as it is an intellectual trait, and so there is no disadvantage to having a high sense trait. As a result, the sense trait often increases infinitely as there is no limiting factor to lead to the organisms having a disadvantage. This is similar to brain development in humans - brain development can lead to large advantages with little limiting factors. It is important to note that brain development is still limited by energy consumption (a brain uses a lot of energy) and physical limitations such as head size.
				</div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/Size.PNG" alt="Organisms with different sizes">
				</div>

				<div class="left">
					<h2>The size trait</h2>
					The size trait is how big an organism is. Being big provides an advantage as it allows organisms to predate smaller organisms and so gain more energy. However, similar to speed it is limited by kinetic energy, with a larger mass requiring more energy to move. Therefore, also similarly to speed the size trait strikes a balance between being large enough to predate other organisms (and prevent themselves from being predated!) but being small enough that excessive energy is not wasted on being large. 
					However, this limitation of requiring food can be removed either by removing the kinetic energy feature (like speed) or by increasing the food value and spawn rate. Increasing the food value and spawn rate means that size is no longer limited by energy requirements, leading to massive organisms. Furthermore, when an organism becomes large enough, the food will spawn within the organism, meaning that it does not have to move in order to receive energy. This means that high speed is not required anymore, allowing even larger sizes to be supported.
				</div>
			</div>

			<div class="item horizontal">
				<div class="right">
					<img src="Images/Mutations.PNG" alt="Graph of varying traits">
				</div>

				<div class="left">
					<h2>Genetic drift - why does the simulation run differently with the same settings?</h2>
					By refreshing the simulation multiple times and seeing how the simulation plays out, the same settings can lead to different results - sometimes the organisms gain a large size with slow speed, sometimes a small size with high speed. This is due to genetic drift. Genetic drift is the effect of random events on the population, and has a larger effect in small populations where one individual can represent a large proportion of the population's alleles. As a result, the death of one individual due to random chance (such as the organism being unable to find food in time) can result in the high speed allele being removed from the population, and can hence result in the population consisting of large, slow individuals instead. Because the simulation is small with only 5 - 10 organisms, genetic drift has a large influence over the population, and can result in different results for the same settings.
				</div>
			</div>
		</div>
    </body>
</html>