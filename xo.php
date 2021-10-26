<script LANGUAGE="JavaScript">
<!--
var i=0;
var cell = new Array(9);
for (i=0; i<9; i++) cell[i] = 0;

x = new Image(128,128);
x.src = "image/x.gif";
o = new Image(128,128);
o.src = "image/o.gif";
e = new Image(128,128);
e.src = "image/z.gif";

function xoz(xo) {
	switch (xo) {
		case 1:
			x.src = "image/x.jpg"
			o.src = "image/o.jpg"
			e.src = "image/z.jpg"
			break
		case 2:
			x.src = "image/x.png"
			o.src = "image/o.png"
			e.src = "image/z.png"
			break
		case 3:
			x.src = "image/x.gif"
			o.src = "image/o.gif"
			e.src = "image/z.gif"
			break
}
}

function Cross(value) {
	for (i=0; i<9; i++)	if (value == i) document["pole"+i].src = x.src;
}

function Zero(value) {
	for (i=0; i<9; i++)	if (value == i) document["pole"+i].src = o.src;
}

function CheckVictory() {
  if (cell[0] == cell[1] && cell[1] == cell[2] && cell[2] > 0) return true; 
  if (cell[3] == cell[4] && cell[4] == cell[5] && cell[5] > 0) return true;
  if (cell[6] == cell[7] && cell[7] == cell[8] && cell[8] > 0) return true;
  if (cell[6] == cell[3] && cell[3] == cell[0] && cell[0] > 0) return true;
  if (cell[7] == cell[4] && cell[4] == cell[1] && cell[1] > 0) return true;
  if (cell[8] == cell[5] && cell[5] == cell[2] && cell[2] > 0) return true;
  if (cell[6] == cell[4] && cell[4] == cell[2] && cell[2] > 0) return true;
  if (cell[0] == cell[4] && cell[4] == cell[8] && cell[8] > 0) return true;
}

function CompTurn() {
  for (i=0; i<9; i++) if (cell[i] == 0) PutHere = i;
 
  for (i=0; i<3; i++) {
	  if (cell[4] == cell[1] && cell[2] == 0 && cell[0] == i) PutHere = 2;
  if (cell[0] == cell[1] && cell[2] == 0 && cell[0] == i) PutHere = 2;
  if (cell[0] == cell[2] && cell[1] == 0 && cell[0] == i) PutHere = 1;
  if (cell[1] == cell[2] && cell[0] == 0 && cell[2] == i) PutHere = 0;
  if (cell[3] == cell[4] && cell[5] == 0 && cell[3] == i) PutHere = 5;
  if (cell[3] == cell[5] && cell[4] == 0 && cell[3] == i) PutHere = 4;
  if (cell[4] == cell[5] && cell[3] == 0 && cell[5] == i) PutHere = 3;
  if (cell[6] == cell[7] && cell[8] == 0 && cell[6] == i) PutHere = 8;
  if (cell[6] == cell[8] && cell[7] == 0 && cell[6] == i) PutHere = 7;
  if (cell[7] == cell[8] && cell[6] == 0 && cell[8] == i) PutHere = 6;

  if (cell[6] == cell[3] && cell[0] == 0 && cell[6] == i) PutHere = 0;
  if (cell[6] == cell[0] && cell[3] == 0 && cell[6] == i) PutHere = 3;
  if (cell[3] == cell[0] && cell[6] == 0 && cell[3] == i) PutHere = 6;
  if (cell[7] == cell[4] && cell[1] == 0 && cell[7] == i) PutHere = 1;
  if (cell[7] == cell[1] && cell[4] == 0 && cell[7] == i) PutHere = 4;
  if (cell[4] == cell[1] && cell[7] == 0 && cell[4] == i) PutHere = 7;
  if (cell[8] == cell[5] && cell[2] == 0 && cell[8] == i) PutHere = 2;
  if (cell[8] == cell[2] && cell[5] == 0 && cell[8] == i) PutHere = 5;
  if (cell[5] == cell[2] && cell[8] == 0 && cell[5] == i) PutHere = 8;

  if (cell[6] == cell[4] && cell[2] == 0 && cell[6] == i) PutHere = 2;
  if (cell[6] == cell[2] && cell[4] == 0 && cell[6] == i) PutHere = 4;
  if (cell[4] == cell[2] && cell[6] == 0 && cell[4] == i) PutHere = 6;
  if (cell[0] == cell[4] && cell[8] == 0 && cell[0] == i) PutHere = 8;
  if (cell[0] == cell[8] && cell[4] == 0 && cell[0] == i) PutHere = 4;
  if (cell[4] == cell[8] && cell[0] == 0 && cell[4] == i) PutHere = 0;
  if (cell[4] == 0) PutHere = 4;
  }
  Zero(PutHere);
  cell[PutHere] = 2;
  if (CheckVictory() == true) {
    alert("Выиграл JavaScript =).");
    GameOver();
  }
}

function GameOver() {
  for (i=0; i<9; i++) {
	cell[i] = 0;
  	document["pole"+i].src = e.src;}
}

function CheckNobody() {
  no = false;
  for (i=0; i<9; i++) if (cell[i] == 0) no = true;
  if (no == false) {
    alert("Ничья.");
    GameOver();
  }
}

function Place(value) {
  if (cell[value] == 0) {
    Cross(value);
    cell[value] = 1;
    if (CheckVictory() == true) {
      alert("Ты выиграл. Поздравляю.");
      GameOver();
    }
    else {
      CheckNobody();
      CompTurn();
      CheckNobody();
    }
  }
}
//-->
</script>
<tt>

<p ALIGN="center"><font COLOR="#00ff00">Крестики-нолики</font><br>
<br>
</p>
<div align="center">

<table>
<?
$n=0;
for ($i=0;$i<3;$i++){
	echo "<tr>";
	for ($j=0;$j<3;$j++){
		echo '<td align="center"><img SRC="image/z.gif" NAME="pole'.$n.'" onClick="Place('.$n.')" WIDTH="128" HEIGHT="128"></td>';
		$n++;
	}
	echo "</tr>";
}
  ?>
<input type="button" value="Стиль1" onclick="xoz(1)">
<input type="button" value="Стиль2" onclick="xoz(2)">
<input type="button" value="По умолчанию" onclick="xoz(3)">
</table>
</div>