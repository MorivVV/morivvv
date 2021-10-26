<!DOCTYPE html>
<html>
 <head>
  <title>canvas</title>
  <meta charset="utf-8">
  <script> 
   function smile() {
    var drawingCanvas = document.getElementById('smile');
    if(drawingCanvas && drawingCanvas.getContext) {
     var context = drawingCanvas.getContext('2d');
	 var CellR = document.getElementById('rad').value;
	 // Рисуем горизонтальные линии 
	/* context.strokeStyle = "#eee";
	 for (var x = 0.5; x < 200; x += 10) {
		context.moveTo(x, 0);
		context.lineTo(x, 200);
	}
	// Рисуем вертикальные линии 
	for (var y = 0.5; y < 200; y += 10) {
		context.moveTo(0, y);
		context.lineTo(200, y);
	}
	context.stroke();*/
     // Рисуем окружность 
     context.strokeStyle = "#000";
     context.fillStyle = "#ff0";
     context.beginPath();
     context.arc(100,100,CellR,0,Math.PI*2,true);
     context.closePath();
     context.stroke();
     context.fill();
     // Рисуем левый глаз 
     context.fillStyle = "#fff";
     context.beginPath();
	 //запоминаем координаты
	 context.save();
	 /*
	   * Масштабируем по х.
	   * Теперь нарисованная окружность вытянется в a / b раз
	   * и станет эллипсом
	   */
	 context.scale(2, 1);
     context.arc(42,90,5,0,Math.PI*2,true);
     context.closePath();
     context.stroke();
     context.fill();
     // Рисуем правый глаз 
     context.beginPath();
     context.arc(58,90,5,0,Math.PI*2,true);
     context.closePath();
	 // Восстанавливаем СК и масштаб
	 context.restore();
     context.stroke();
     context.fill();
     // Рисуем рот
     context.beginPath();
	<?
	if  (isset($_COOKIE['USER']) and isset($_COOKIE['PASS'])){ 
		echo "context.moveTo(70,115);";	  
		echo "context.quadraticCurveTo(100,130,130,115);";	  
		echo "context.quadraticCurveTo(100,150,70,115);";}
	else
		echo "context.arc(100,160,40,Math.PI*1.25,Math.PI*1.75);";
	 ?>
     context.closePath();
     context.stroke();
     context.fill();
    }
   }
  </script>
 </head>
 <body>
	<input type="text" id="rad"><input type="button" value="Обновить" onclick="smile()">
  <canvas id="smile" width="300" height="300">
    <p>Ваш браузер не поддерживает рисование.</p>
  </canvas>
 </body>
</html>