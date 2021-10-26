<?php
$dirfoto = "image/tumbs/";
	function calcHeight ($files, $c) {
		$max = 180;
		global $dirfoto;
		$width = 890;
		$margin = 1;
		$he =500;
		$i = $c;
		while ($he > $max && $i < count($files)) {
			$coef = 0;
			list($w[$i], $h[$i]) = getimagesize($dirfoto.$files[$i]);
			for ($j=$c;$j<=$i;$j++) 
				$coef = $coef + ($w[$j])*($h[$c])/($h[$j]);
			$he = ($width-2*$margin*($i-$c))*$h[$c]/$coef;
			$i++;
		}
		$i--;
		for ($j=$c;$j<=$i;$j++) {
			echo "<img src='".$dirfoto.$files[$j]."' height=".$he."/>";
		}
		return  $i+1;
	}
	function excess($files) {/* Функция для удаления лишних файлов: сюда, помимо удаления текущей и родительской директории, так же можно добавить файлы, не являющиеся картинкой (проверяя расширение) */
		$result = array();
		for ($i = 0; $i < count($files); $i++) {
		  if (strstr($files[$i], ".jpg") == ".jpg") $result[] = $files[$i];
		}
		return $result;
	}
	
?>
<link rel="stylesheet" type="text/css" media="screen" href="css/gp-gallery.css"/>
<style type="text/css">
	body {
		background: black;
	}
	img {
		margin:1px;
	}
	.pictures {
		margin: 50px auto;
		width: 900px;
	}
	.clear {
		clear: both;
	}
</style>
<div class="pictures">
<?php 
$files = scandir($dirfoto);
$files = excess($files);
$c = 0;
while ($c < count($files) )
	$c = calcHeight ($files, $c);
?>
</div>
