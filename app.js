var animals = [];
var food = [];
var frames = 0;
var food_spawn_rate = 10;
var start_speed = 3;
var start_sense_distance = 75;
var mutation_change_rate = 0.1;
var eating_size_percentage = 0.5;
var food_value = 100;

var food_spawn_slider = document.getElementById("food_spawn_slider");
var food_spawn_output = document.getElementById("food_spawn_value");
var food_value_slider = document.getElementById("food_value_slider");
var food_value_output = document.getElementById("food_value_value");

var population_output = document.getElementById("population_value");
var average_speed_output = document.getElementById("average_speed_value");
var average_sense_output = document.getElementById("average_sense_value");
var average_size_output = document.getElementById("average_size_value");
food_spawn_output.innerHTML = Math.ceil(50 / food_spawn_slider.value);
food_value_output.innerHTML = food_value_slider.value;

food_spawn_slider.oninput = function () {
    food_spawn_output.innerHTML = this.value;
    food_spawn_rate = Math.ceil(50 / this.value);
}

food_value_slider.oninput = function () {
    food_value_output.innerHTML = this.value;
    food_value = parseInt(this.value, 10);
}

function startGame() {
    myGameArea.start();
}

var myGameArea = {
    canvas: document.createElement("canvas"),
    start: function () {
        this.canvas.width = 480;
        this.canvas.height = 270;
        for (i = 0; i < 3; i++) {
            food.push(new component(5, 5, "green", Math.floor(Math.random() * this.canvas.width), Math.floor(Math.random() * this.canvas.height)));
        }
        for (i = 0; i < 5; i++) {
            animals.push(new component(20, 20, "#FF0000", Math.floor(Math.random() * this.canvas.width), Math.floor(Math.random() * this.canvas.height)));
        }

        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.interval = setInterval(updateGameArea, 20);
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
    this.update = function () {
        ctx = myGameArea.context;
        ctx.fillStyle = color;
        ctx.fillRect(this.x, this.y, this.width, this.height);
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

        if (shortestDistance != element.sense_distance) {
            element.angle = newAngle;
        }

        element.x += element.speed * Math.cos(element.angle);
        element.y += element.speed * Math.sin(element.angle);
        element.energy -= 0.5 * ((element.width * element.height) / 400) * Math.pow(element.speed / start_speed, 2) + 1;
        element.update();
        if (element.energy < 0) {
            animals.splice(animals.indexOf(element), 1);
        }
        else if (element.energy >= 600) {
            for (i = 1; i <= 2; i++) {
                if (Math.random() < 0.5) { element.speed = element.speed * (1 - mutation_change_rate); }
                else { element.speed = element.speed * (1 + mutation_change_rate); }

                if (Math.random() < 0.5) { element.sense_distance = element.sense_distance * (1 - mutation_change_rate); }
                else { element.sense_distance = element.sense_distance * (1 + mutation_change_rate); }

                colour = Math.round((90 / Math.PI) * Math.atan(element.sense_distance - start_sense_distance - 10) + 45);
                if (colour.toString().length == 1) { colour = "0" + colour }

                if (Math.random() < 0.5) { element.width = element.width * (1 - mutation_change_rate); }
                else { element.width = element.width * (1 + mutation_change_rate); }
                if (element.width < 1) { element.width = 1 }
                element.height = element.width;

                animals.push(new component(element.width, element.height, "#FF00" + colour, element.x, element.y, element.speed, element.sense_distance));
            }
            animals.splice(animals.indexOf(element), 1);
        }
    })

    for (i = 0; i < food.length; i++) {
        food[i].update();
    }

    if (frames % food_spawn_rate == 0) {
        food.push(new component(5, 5, "green", Math.floor(Math.random() * myGameArea.canvas.width), Math.floor(Math.random() * myGameArea.canvas.height)));
    }

    if (frames % 50 == 0) {
        average_speed_output.innerHTML = (total_speed / animals.length).toFixed(2);
        average_sense_output.innerHTML = (total_sense / animals.length).toFixed(2);
        average_size_output.innerHTML = (total_size / animals.length).toFixed(2);
        population_output.innerHTML = animals.length;
    }
}