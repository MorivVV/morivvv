<link rel='stylesheet' type='text/css' media="screen" href='/css/snake.css' />
<div id="snake"><input type="button" onclick="fScreen()" value="+/-"><span class="score"></span>
{if $width>15}<span class="game-info">Управление стрелочками или клавишами W,S,A,D</span>{/if}<br></div>
<div id="topscore"></div>
<script>
	printTable();
	var snake = [];
	var step = 0;
	var speed = 500;
	var trace =270;
	var score =0;
	var dead;
	var startx = 0;
	var starty = 0;
	$("#topscore").load("/snakeScore$",{ "score": score , "speed": parseInt(500/speed*100)});
	start();
	function fScreen(){
		var game = document.getElementById("snake")
		if (game.style.top == "30px") {
			game.style.top = "";
			game.style.zIndex = "";	
		}	
		else {
			game.style.top = "30px";
			game.style.zIndex = "1000";
		}
		step = 0;
	}
	function printTable() {
		var table = document.createElement('table');
		table.id = "snake-field";
		var body =  "<tbody>";
		for (var i=1;i<={$height};i++) {
			body += "<tr>";
			for (var j=1;j<={$width};j++){
				body +=  "<td id="+i+"-"+j+ '></td>';
			}
			body += "</tr>";
		}
		body += "</tbody>";
		table.innerHTML = body;
		var game = document.getElementById("snake");
		game.appendChild(table);
	}
	function start(){
		dead = false;
		step = 0;
		score = 0;
		snake = ["7-3","7-4","7-5","7-6","7-7","7-8"];
		addEventListener("keydown", PressKey);
		
		addEventListener('touchstart', function(e){
			var touchobj = e.changedTouches[0] // первая точка прикосновения
			startx = parseInt(touchobj.clientX) // положение точки касания по x, относительно левого края браузера
			starty = parseInt(touchobj.clientY)
			//e.preventDefault()
		}, false)
		
		addEventListener('touchmove', function(e){
			var touchobj = e.changedTouches[0] // первая точка прикосновения для данного события
			if (e.changedTouches.length == 3)
				fScreen();
			var distx = parseInt(touchobj.clientX) - startx
			var disty = parseInt(touchobj.clientY) - starty
			var tou = (Math.abs(distx)<Math.abs(disty))*2
			if (tou>0)
				tou += (disty>0)
			else
				tou += (distx>0)
			switch (tou){
				case 0://лево
					step = 37
					break;
				case 1://право
					step = 39
					break;	
				case 2://вверх
					step = 38
					break;
				case 3://вниз
					step = 40
					break;	
				default:
					step = 65
					break;
			}
			e.preventDefault()
		}, false)
		viewSnake();
		NewApple();
		handle();
	}
	function viewSnake(){
		for (var i = 0; i < snake.length; i++) {
			document.getElementById(snake[i]).setAttribute("name","snake-body");
			document.getElementById(snake[i]).innerHTML = "";
		}
		document.getElementById(snake[snake.length-1]).setAttribute("name","snake-head");
		document.getElementById(snake[snake.length-1]).style.transform = 'rotate('+ trace + 'deg)';
		score = parseInt(snake.length-6);
		document.querySelector(".score").innerHTML = " Счет:" + score + ", скорость:"+ parseInt(500/speed*100) + "%";
	}
	function PressKey(e){
		step = e.keyCode
	}
	function handle() {
		var tik = snake[snake.length-1].split("-");
		if (step==0) {
			setTimeout(handle,speed);
			return false;
		}
		if (dead) 
			return false;
		switch (step){
			case 37://лево
			case 65://A
				tik[1] = (Number(tik[1])-1)%{$width};
				if (tik[1]==0) tik[1]={$width};
				trace = 90;
				break;
			case 38://вверх
			case 87://W
				tik[0] = (Number(tik[0])-1)%{$height};
				if (tik[0]==0) tik[0]={$height};
				trace = 180;
				break;
			case 39://право
			case 68://D
				tik[1] = (Number(tik[1])+1)%{$width};
				if (tik[1]==0) tik[1]={$width};
				trace = 270;
				break;
			case 40://вниз
			case 83://S
				tik[0] =(Number(tik[0])+1)%{$height};
				if (tik[0]==0) tik[0]={$height};
				trace = 0;
				break;
			default:
				setTimeout(handle,speed);
				return false;
				break;
		}
		if (document.getElementById(tik[0]+"-"+tik[1]).getAttribute("name") == "apple"){
			NewApple();
		}
		else if (document.getElementById(tik[0]+"-"+tik[1]).getAttribute("name") == "snake-body") {
			dead = true;
			RipSnake(snake.length);
			return false;
		}
		else {
			document.getElementById(snake.shift()).removeAttribute("name");
		}
		snake.push(tik[0]+"-"+tik[1]);
		viewSnake();
		setTimeout(handle,speed);
	}
	function NewApple(){
		var x = Math.floor(Math.random() * ({$height} - 1) + 1);
		var y = Math.floor(Math.random() * ({$width} - 1) + 1);
		if (snake.indexOf(x + "-" + y) == -1) {
			document.getElementById(x + "-" + y).setAttribute("name","apple");
			speed -= speed/100;
		}
		else
			NewApple();
	}
	function RipSnake(i){
		document.getElementById(snake.pop()).removeAttribute("name");
		i--;
		if (i>0) 
			setTimeout(RipSnake,100,i);
		else{
			setTimeout(start,100);
			$("#topscore").load("/snakeScore$",{ "score": score , "speed": parseInt(500/speed*100)});
		}			
	}

</script>