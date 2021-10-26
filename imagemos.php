<?php
echo<<<HTML
<html>
<head>
<title>Demo ImageMos by Squier</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="content-language" content="ru">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
</head>
<body>
HTML;

function getExtension($filename) {
        return end(explode(".", $filename));
      }
function totranslit($var, $lower = true, $punkt = true) {
	global $langtranslit;
	
	if ( is_array($var) ) return "";

	if (!is_array ( $langtranslit ) OR !count( $langtranslit ) ) {

		$langtranslit = array(
		'а' => 'a', 'б' => 'b', 'в' => 'v',
		'г' => 'g', 'д' => 'd', 'е' => 'e',
		'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
		'и' => 'i', 'й' => 'y', 'к' => 'k',
		'л' => 'l', 'м' => 'm', 'н' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r',
		'с' => 's', 'т' => 't', 'у' => 'u',
		'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
		'ь' => '', 'ы' => 'y', 'ъ' => '',
		'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
		"ї" => "yi", "є" => "ye",
		
		'А' => 'A', 'Б' => 'B', 'В' => 'V',
		'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
		'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
		'И' => 'I', 'Й' => 'Y', 'К' => 'K',
		'Л' => 'L', 'М' => 'M', 'Н' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R',
		'С' => 'S', 'Т' => 'T', 'У' => 'U',
		'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
		'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
		'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		"Ї" => "yi", "Є" => "ye",
		);

	}
	
	$var = trim( strip_tags( $var ) );
	$var = preg_replace( "/\s+/ms", "-", $var );

	$var = strtr($var, $langtranslit);
	
	if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
	else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

	$var = preg_replace( '#[\-]+#i', '-', $var );

	if ( $lower ) $var = strtolower( $var );

	$var = str_ireplace( ".php", "", $var );
	$var = str_ireplace( ".php", ".ppp", $var );

	if( strlen( $var ) > 200 ) {
		
		$var = substr( $var, 0, 200 );
		
		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
	
	}
	
	return $var;
}
function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}



if($_REQUEST['add']) {
$_POST['widthdef']=(int)$_POST['widthdef'];
$_POST['heightdef']=(int)$_POST['heightdef'];
$_POST['margin']=(int)$_POST['margin'];
if($_POST['widthdef']>100 ) $widthdef=$_POST['widthdef']; else $widthdef=800;
if($_POST['heightdef']>50 ) $heightdef=$_POST['heightdef']; else $heightdef=150;
if($_POST['heightdef']>=0 ) $margin=$_POST['margin']; else $margin=2;
echo 'Width block:'.$widthdef.'<br>Height string:'.$heightdef.'<br>Margin:'.$margin;
$uploadsdir='./upload/';
echo '<div style="width:'.$widthdef.'px;">';


$imagescount=0;
foreach ($_FILES["pictures"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
 $tmp=getExtension($_FILES["pictures"]["name"][$key]);
if($tmp=='png' || $tmp=='jpg' || $tmp=='gif' || $tmp=='jpeg'){
      $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
        $names = $_FILES["pictures"]["name"][$key];
	$filegl=time().'_'.totranslit($names);
        move_uploaded_file($tmp_name, $uploadsdir.$filegl);
	list($widtha, $heighta) = getimagesize($uploadsdir.$filegl);
$hi=$heighta*$widthdef/$widtha;
if ($hi<$heightdef) resize($uploadsdir.$filegl, $uploadsdir.$filegl, $widthdef, 0); else resize( $uploadsdir.$filegl,  $uploadsdir.$filegl, 0, $heightdef);
$imagescount++;
$img[$imagescount]=$filegl;
   }
}
}


$images=0;
$first=1;

while($first<=$imagescount){
	$images=$first-1;
	$hightes=$heightdef+1;
		while($hightes > $heightdef && $images<$imagescount) {
			$images++;
			$width=$widthdef-($images-$first+1)*($margin*2);
			list($w[$images], $h[$images]) = getimagesize($uploadsdir.$img[$images]);
	
			$delim=$width*$h[$first];
	
			$delit=$w[$first];
	
			for($j=($first+1);$j<=$images;$j++) {
				$delit=$delit+$w[$j]*($h[$first]/$h[$j]);
			}
			$hightes=floor($delim/$delit);
			

			if($hightes<=$heightdef) {
				for($i=$first;$i<=$images;$i++) {
					$ht=$hightes.'px';
					echo '<img style="margin:'.$margin.'px;" src="'.$uploadsdir.$img[$i].'" height="'.$ht.'">';
					
				}
				$first=$images+1;
		
			} else {

				if($images==$imagescount) {
			
					for($y=$first;$y<=$images;$y++) {
						echo '<img style="margin:'.$margin.'px;" src="'.$uploadsdir.$img[$y].'" height="'.$heightdef.'">';
					}
					$first=$images+1;
				}
	
			}

		}
}

echo '</div>';
}
echo<<<HTML
<script type="text/javascript">
var total = 0;
function add_new_image(){
	total++;
	$('<tr>')
	.attr('id','tr_image_'+total)
	.css({lineHeight:'30px'})
	.append (
		$('<td width="250px">')
		
		.append(
			$('<input type="file" />')
			
			
			.attr('name','pictures[]')
		)		
		
	)
	
	.append (
		$('<td width="80px">')
		
		.append (
			$('<input type="button" value="+" id="add" onclick="return add_new_image();">')
		)
	)
	.appendTo('#table_container');
	
}
$(document).ready(function() {
	add_new_image();
});
</script>
HTML;
echo '<form enctype=\'multipart/form-data\' action="" method="POST"><table><tr><td>Width block:</td><td><input type="text" value="800" name="widthdef"></td></tr><tr><td>Height string:</td><td><input type="text" value="150" name="heightdef"></td></tr><tr><td>Margin:</td><td><input type="text" value="2" name="margin"></td></tr></table><table id="table_container"></table><br><input type="submit" name="add"></form>';
echo<<<HTML
</body>
HTML;
?>
