<body>
<?php
include "createTable.php";
$height = 20;
$width = 30;
$tb1 = new mTable;
$tb1->setSize($height,$width);
$tb1->setStyle('style="height: 30px; width: 30px;"');
$tb1->printTable();
?>
</body>
<script>
	var snake = [];
	var dead;
	start();
	function start(){
		dead = false;
		snake = ["7-3","7-4","7-5","7-6","7-7","7-8"];
		addEventListener("keydown", handle);
		viewSnake();
		NewApple();
	}
	function viewSnake(){
		for (var i = 0; i < snake.length; i++) {
			document.getElementById(snake[i]).style.background = "red";
		}
		document.getElementById(snake[snake.length-1]).style.background = "black";
	}
	function handle(e) {
		var tik = snake[snake.length-1].split("-");
		if (e === undefined || dead) 
			return false;
		switch (e.keyCode){
			case 37://лево
			case 65://A
				tik[1] = (Number(tik[1])-1)%<? echo $width ?>;
				if (tik[1]==0) tik[1]=<? echo $width ?>;
				break;
			case 38://вверх
			case 87://W
				tik[0] = (Number(tik[0])-1)%<? echo $height ?>;
				if (tik[0]==0) tik[0]=<? echo $height ?>;
				break;
			case 39://право
			case 68://D
				tik[1] = (Number(tik[1])+1)%<? echo $width ?>;
				if (tik[1]==0) tik[1]=<? echo $width ?>;
				break;
			case 40://вниз
			case 83://S
				tik[0] =(Number(tik[0])+1)%<? echo $height ?>;
				if (tik[0]==0) tik[0]=<? echo $height ?>;
				break;
			default:
				return false;
				break;
		}
		if (document.getElementById(tik[0]+"-"+tik[1]).style.background == "green"){
			NewApple();
		}
		else if ((document.getElementById(tik[0]+"-"+tik[1]).style.background == "red")) {
			dead = true;
			RipSnake(snake.length);
			return false;
		}
		else {
			document.getElementById(snake.shift()).style.background = "white";
		}
		snake.push(tik[0]+"-"+tik[1]);
		viewSnake();
		return false;
	}
	function NewApple(){
		var x = Math.floor(Math.random() * (<? echo $height ?> - 1) + 1);
		var y = Math.floor(Math.random() * (<? echo $width ?> - 1) + 1);
		if (snake.indexOf(x + "-" + y) == -1)
			document.getElementById(x + "-" + y).style.background = "green";
		else
			NewApple();
	}
	function RipSnake(i){
		document.getElementById(snake.pop()).style.background = "white";
		i--;
		if (i>0) 
			setTimeout(RipSnake,100,i);
		else	
			setTimeout(start,100);		
	}

</script>