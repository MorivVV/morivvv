<h2>КОпирование файлов</h2>
<?php
$a = 1;
if (isset($_GET['a']))
	$a=$_GET['a'];
$i = 0;
for ($i=$a;$i<=$a+250;$i++){
	echo "<img src=https://vk.com/images/stickers/$i/128.png>";
}
echo "<a href=getvk.php?a=$i >дальше</a>";
?>