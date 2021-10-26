<?php

function basicRow(){
  $ofset=0;
  for ($i=1; $i<=81; $i++) {
    if ($i==28)  $ofset = 1;
    if ($i==55)  $ofset = 2;
    $sudoku[$i] = 1 + ($ofset + $i - 1 + 3 * (int)(($i - 1)/9)) % 9;
  }
  return $sudoku;
}

function convertPos($x, $y, $pos)  {
  if ($pos) 
    return ($x % 9) * 9 + ($y % 9) + 1;
  else
    return ($y % 9) * 9 + ($x % 9) + 1;
}

function swapColumnSector($sudoku, $pos, $cub){
	$y1 = $y2 = $n = $m = 0;
  if ($cub) {
    $n = 2;
    $m = 3;
  }
  $rnd = rand(1,9);
  
 if ($n == 0) {
    $y1 = ($rnd - 1) % 3;
    switch ($y1) {
      case 0:
	  case 1:
        $y2 = $y1 + 1;
		break;
      case 2:
        $y2 = $y1 - 2;
		break;
	}
  }
   for ($i = 0; $i<=8; $i++) 
    for ($j = 0; $j<=$n; $j++) {
	  $temp = $sudoku[convertPos(3 * (int)(($rnd - 1) / 3) + $y1 + $j, $i, $pos)];
      $sudoku[convertPos(3 * (int)(($rnd - 1) / 3) + $y1 + $j, $i, $pos)] = $sudoku[convertPos(3 * (int)(($rnd - 1) / 3) + $y2 + $m + $j, $i, $pos)];
      $sudoku[convertPos(3 * (int)(($rnd - 1) / 3) + $y2 + $m + $j, $i, $pos)] = $temp;
    }
	return $sudoku;
}

function gamePos($sudoku)  {
  for ($i=1;$i<=81;$i++) {
	  if (rand(1,9)<=5) $sudoku[$i] = 0;
  }
  return $sudoku;
}

$sudoku = basicRow();

for ($i=1; $i<=41; $i++) {
	$sudoku = swapColumnSector($sudoku, $i % 2 == 0, $i % 4 > 1);
}
$sudoku = gamePos($sudoku);

$smarty = new Smarty;
$smarty->assign('sudoku',$sudoku);
$smarty_tpl = 'sudoku.tpl';
?>



