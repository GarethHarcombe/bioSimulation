var animals = [];
var food = [];
var frames = 0;
var food_spawn_rate = 10;
var start_speed = 3;
var start_sense_distance = 75;
var mutation_change_rate = 0.1;
var eating_size_percentage = 0.5;
var food_value = 100;
var paused = false;
var frame_rate = 20;
var interval;

var red_colour = "#FF0000";
var blue_colour = "#2337FF";
var yellow_colour = "#FFCC00";

var population_data = [];
var food_data = [];
var size_data = [];
var speed_data = [];
var sense_data = [];
var highest_population = 1;
var highest_food = 1;
var highest_size = 1;
var highest_speed = 1;
var highest_sense = 1;
var time = [];
var time_mutations = [];
var overall_chart = document.getElementById("overall_chart").getContext('2d');
var overall_chart_var = new Chart(overall_chart, {
    type: 'line',
    data: {
        labels: time,
        datasets: [{
            label: 'Population',
            data: population_data,
            fill: false,
            backgroundColor: red_colour,
            borderColor: red_colour,
            borderWidth: 1,
            pointStyle: "rect"
        },
        {
            label: 'Food',
            data: food_data,
            fill: false,
            backgroundColor: blue_colour,
            borderColor: blue_colour,
            borderWidth: 1
        }]
    },
    options: {
        animation: {
            duration: 0
        },
        responsive: true,
        maintainAspectRatio: false,
        tooltips: { enabled: false },
        hover: { mode: null },
        title: {
            display: true,
            text: 'Stats over Time'
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Time (seconds)'
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true
                },
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value Relative to Maximum'
                }
            }]
        }
    }
});

var mutations_checkbox = document.getElementById("mutations_checkbox");

var pause_play_button = document.getElementById("pause_play_button");
pause_play_button.onclick = pausePlayGame;
var sim_speed_slider = document.getElementById("sim_speed_slider");
var sim_speed_output = document.getElementById("sim_speed_value");

var food_spawn_slider = document.getElementById("food_spawn_slider");
var food_spawn_output = document.getElementById("food_spawn_value");
var food_value_slider = document.getElementById("food_value_slider");
var food_value_output = document.getElementById("food_value_value");

var population_output = document.getElementById("population_value");
var average_speed_output = document.getElementById("average_speed_value");
var average_sense_output = document.getElementById("average_sense_value");
var average_size_output = document.getElementById("average_size_value");

sim_speed_slider.value = 400 / speedPHP;
food_spawn_slider.value = 50 / spawnPHP;
food_value_slider.value = nutritionPHP;

sim_speed_output.innerHTML = (20 / speedPHP).toFixed(2);
food_spawn_output.innerHTML = (50 / spawnPHP).toFixed(0);
food_value_output.innerHTML = nutritionPHP;

frame_rate = speedPHP;
food_spawn_rate = spawnPHP;
food_value = nutritionPHP;

sim_speed_slider.oninput = function () {
    if (paused == true) {
        pausePlayGame();
    }
    sim_speed_output.innerHTML = (this.value / 20).toFixed(2);
    frame_rate = 400 / this.value;
    window.clearInterval(interval);
    interval = setInterval(updateGameArea, frame_rate);
    document.getElementById("speed_hidden").value = frame_rate;
}

food_spawn_slider.oninput = function () {
    food_spawn_output.innerHTML = this.value;
    food_spawn_rate = (50 / this.value).toFixed(0);
    console.log(food_spawn_rate);
    document.getElementById("spawn_hidden").value = food_spawn_rate;
}

food_value_slider.oninput = function () {
    food_value_output.innerHTML = this.value;
    food_value = parseInt(this.value, 10);
    document.getElementById("nutrition_hidden").value = food_value;
}

if (mutations_speedPHP == mutations_sensePHP && mutations_sensePHP == mutations_sizePHP && mutations_sizePHP == false) {
    mutationsPHP = false;
}

if (mutationsPHP == true) {
    mutations_checkbox.checked = true;
    var mutations_chart = document.getElementById("mutations_chart").getContext('2d');
    var mutations_chart_var = new Chart(mutations_chart, {
        type: 'line',
        data: {
            labels: time_mutations,
            datasets: [
                {
                    label: 'Average Speed',
                    data: speed_data,
                    fill: false,
                    backgroundColor: blue_colour,
                    borderColor: blue_colour,
                    borderWidth: 1,
                    pointStyle: "triangle"
                },
                {
                    label: 'Average Sense Distance',
                    data: sense_data,
                    fill: false,
                    backgroundColor: yellow_colour,
                    borderColor: yellow_colour,
                    borderWidth: 1,
                },
                {
                    label: 'Average Size',
                    data: size_data,
                    fill: false,
                    backgroundColor: red_colour,
                    borderColor: red_colour,
                    borderWidth: 1,
                    pointStyle: "rect"
                }]
        },
        options: {
            animation: {
                duration: 0
            },
            responsive: true,
            maintainAspectRatio: false,
            tooltips: { enabled: false },
            hover: { mode: null },
            title: {
                display: true,
                text: 'Stats over Time'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Time (seconds)'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value Relative to Maximum'
                    }
                }]
            }
        }
    });
}
else {
    document.getElementById("mutations_chart").parentNode.removeChild(document.getElementById("mutations_chart"));
}

if (mutations_speedPHP == true) {
    document.getElementById("mutations_speed_checkbox").checked = true;
}

if (mutations_sensePHP == true) {
    document.getElementById("mutations_sense_checkbox").checked = true;
}

if (mutations_sizePHP == true) {
    document.getElementById("mutations_size_checkbox").checked = true;
}

if (kinetic_energyPHP == true) {
    document.getElementById("kinetic_checkbox").checked = true;
}

if (predationPHP == true) {
    document.getElementById("predation_checkbox").checked = true;
}

mutations_checkbox.onclick = function () {
    if (mutations_checkbox.checked == false) {
        document.getElementById("mutations_speed_checkbox").disabled = true;
        document.getElementById("mutations_sense_checkbox").disabled = true;
        document.getElementById("mutations_size_checkbox").disabled = true;
    }
    else {
        document.getElementById("mutations_speed_checkbox").disabled = false;
        document.getElementById("mutations_sense_checkbox").disabled = false;
        document.getElementById("mutations_size_checkbox").disabled = false;
    }
}

function startGame() {
    myGameArea.start();
}

function pausePlayGame() {
    if (paused == false) {
        paused = true;
        window.clearInterval(interval);
        pause_play_button.innerHTML = "Play";
    }
    else {
        paused = false;
        interval = setInterval(updateGameArea, frame_rate);
        pause_play_button.innerHTML = "Pause";
    }
}

var myGameArea = {
    canvas: document.createElement("canvas"),
    start: function () {
        this.canvas.width = 480;
        this.canvas.height = 270;
        for (i = 0; i < 3; i++) {
            food.push(new component(5, 5, blue_colour, Math.floor(Math.random() * this.canvas.width), Math.floor(Math.random() * this.canvas.height)));
        }
        for (i = 0; i < 5; i++) {
            animals.push(new component(20, 20, red_colour, Math.floor(Math.random() * this.canvas.width), Math.floor(Math.random() * this.canvas.height)));
        }

        this.context = this.canvas.getContext("2d");
        document.getElementById("simulation").appendChild(this.canvas);
        interval = setInterval(updateGameArea, frame_rate);
    },
    clear: function () {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }
}

function component(width, height, color, x, y, speed = start_speed, sense_distance = start_sense_distance) {
    this.width = width;
    this.height = height;
    this.x = x;
    this.y = y;
    this.angle = 0;
    this.energy = 300;
    this.speed = speed;
    this.sense_distance = sense_distance;
    this.color = color;
    this.update = function () {
        overall_chart = myGameArea.context;
        overall_chart.fillStyle = color;
        overall_chart.fillRect(this.x, this.y, this.width, this.height);
        mutations_chart = myGameArea.context;
        mutations_chart.fillStyle = color;
        mutations_chart.fillRect(this.x, this.y, this.width, this.height);
    }

    this.crashWith = function (otherobj) {
        var crash = true;
        if ((this.y + (this.height) < otherobj.y) ||
            (this.y > otherobj.y + (otherobj.height)) ||
            (this.x + (this.width) < otherobj.x) ||
            (this.x > otherobj.x + (otherobj.width))) {
            crash = false;
        }
        return crash;
    }
}

function updateGameArea() {
    frames++;
    total_speed = 0;
    total_sense = 0;
    total_size = 0;
    myGameArea.clear();
    animals.forEach(element => {
        total_speed += element.speed;
        total_sense += element.sense_distance;
        total_size += element.width;

        element.angle += (Math.random() * 2 - 1) / 4;
        
        if (element.x < 0) { element.angle = 0; }
        if (element.x > myGameArea.canvas.width - element.width) { element.angle = Math.PI; }
        if (element.y < 0) { element.angle = Math.PI / 2; }
        if (element.y > myGameArea.canvas.height - element.height) { element.angle = 3 * Math.PI / 2; }

        shortestDistance = element.sense_distance;
        newAngle = 0;
        food.forEach(element2 => {
            distance = Math.sqrt(Math.pow(element.x - element2.x, 2) + Math.pow(element.y - element2.y, 2));
            if (distance < shortestDistance) {
                shortestDistance = distance;
                newAngle = Math.atan2(element2.y - element.y, element2.x - element.x);
            }

            if (element.crashWith(element2)) {
                food.splice(food.indexOf(element2), 1);
                element.energy = element.energy + food_value;
                delete element2;
            }
        })

        if (predationPHP == true) {
            animals.forEach(element2 => {
                if (element != element2) {
                    distance = Math.sqrt(Math.pow(element.x - element2.x, 2) + Math.pow(element.y - element2.y, 2));
                    if (distance < element.sense_distance) {
                        if (element.width >= element2.width * (1 + eating_size_percentage) &&
                            distance / (element2.width * element2.height / food_value) < shortestDistance) {
                            shortestDistance = distance / (element2.width * element2.height / food_value);
                            newAngle = Math.atan2(element2.y - element.y, element2.x - element.x);

                            if (element.crashWith(element2)) {
                                element.energy += element2.width * element2.height;
                                animals.splice(animals.indexOf(element2), 1);
                            }
                        }

                        if (element.width <= element2.width * (1 - eating_size_percentage)) {
                            shortestDistance = 1;
                            newAngle = Math.atan2(element2.y - element.y, element2.x - element.x) + Math.PI;
                        }
                    }
                }
            })
        }

        if (shortestDistance != element.sense_distance) {
            element.angle = newAngle;
        }

        element.x += element.speed * Math.cos(element.angle);
        element.y += element.speed * Math.sin(element.angle);

        element.energy -= 1;
        if (kinetic_energyPHP == true) {
            element.energy -= 0.5 * ((element.width * element.height) / 400) * Math.pow(element.speed / start_speed, 2);
        }
        element.update();
        
        if (element.energy < 0) {
            animals.splice(animals.indexOf(element), 1);
        }
        else if (element.energy >= 600) {
            for (i = 1; i <= 2; i++) {
                if (mutationsPHP == true) {
                    if (mutations_speedPHP == true) {
                        if (Math.random() < 0.5) { element.speed = element.speed * (1 - mutation_change_rate); }
                        else { element.speed = element.speed * (1 + mutation_change_rate); }
                    }

                    if (mutations_sensePHP == true) {
                        if (Math.random() < 0.5) { element.sense_distance = element.sense_distance * (1 - mutation_change_rate); }
                        else { element.sense_distance = element.sense_distance * (1 + mutation_change_rate); }
                    }

                    if (mutations_sizePHP == true) {
                        if (Math.random() < 0.5) { element.width = element.width * (1 - mutation_change_rate); }
                        else { element.width = element.width * (1 + mutation_change_rate); }
                        if (element.width < 1) { element.width = 1 }
                        element.height = element.width;
                    }
                }
                colour = red_colour;
                if (element.sense_distance >= start_sense_distance && element.sense_distance <= start_sense_distance + 20)
                {
                    yellow_component = parseInt(((204 / 20) * (element.sense_distance - start_sense_distance)).toFixed(0)).toString(16);
                    if (yellow_component.length == 1) { yellow_component = "0" + yellow_component }
                    colour = "#FF" + yellow_component + "00";
                }

                if (element.sense_distance > start_sense_distance + 20) { colour = yellow_colour; }


                animals.push(new component(element.width, element.height, colour, element.x, element.y, element.speed, element.sense_distance));
            }
            animals.splice(animals.indexOf(element), 1);
        }
    })

    for (i = 0; i < food.length; i++) {
        food[i].update();
    }

    if (frames % food_spawn_rate == 0) {
        food.push(new component(5, 5, blue_colour, Math.floor(Math.random() * myGameArea.canvas.width), Math.floor(Math.random() * myGameArea.canvas.height)));
    }

    if (frames % 250 == 0 && mutationsPHP == true) {
        size_data.push((total_size / animals.length) / highest_size);
        speed_data.push((total_speed / animals.length) / highest_speed);
        sense_data.push((total_sense / animals.length) / highest_sense);
        time_mutations.push(frames / 50);

        if (size_data.length > 50) {
            size_data.shift();
            speed_data.shift();
            sense_data.shift();
            time_mutations.shift();
        }

        if (highest_size < (total_size / animals.length)) {
            size_data.forEach((entry, i) => size_data[i] = entry * highest_size / (total_size / animals.length));
            highest_size = (total_size / animals.length);
        }

        if (highest_speed < (total_speed / animals.length)) {
            speed_data.forEach((entry, i) => speed_data[i] = entry * highest_speed / (total_speed / animals.length));
            highest_speed = (total_speed / animals.length);
        }

        if (highest_sense < (total_sense / animals.length)) {
            sense_data.forEach((entry, i) => sense_data[i] = entry * highest_sense / (total_sense / animals.length));
            highest_sense = (total_sense / animals.length);
        }

        mutations_chart_var.update();
    }

    if (frames % 25 == 0) {
        average_speed_output.innerHTML = (total_speed / animals.length).toFixed(2);
        average_sense_output.innerHTML = (total_sense / animals.length).toFixed(2);
        average_size_output.innerHTML = (total_size / animals.length).toFixed(2);
        population_output.innerHTML = animals.length;

        population_data.push(animals.length / highest_population);
        food_data.push(food.length / highest_food);
        time.push(frames / 50);

        if (population_data.length > 60) {
            population_data.shift();
            food_data.shift();
            time.shift();
        }

        if (highest_population < animals.length) {
            population_data.forEach((entry, i) => population_data[i] = entry * highest_population / animals.length);
            highest_population = animals.length;
        }

        if (highest_food < food.length) {
            food_data.forEach((entry, i) => food_data[i] = entry * highest_food / food.length);
            highest_food = food.length;
        }

        overall_chart_var.update();
    }
}