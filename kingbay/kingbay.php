<?php
require "./simplehtmldom_1_9/simple_html_dom.php";

// Lưu hình ở home
// function saveImage($domain, $imgs) {
// 	foreach($imgs as $img){
// 		$src = $img->src;
// 		$folderSave = 'img/'.basename($src);
// 		file_put_contents($folderSave, file_get_contents($domain.$src));
// 		return basename($src);
// 	}
// }
// L

$domain = "https://kingbay.vn/cap-nhat-thang-4-2018/";
$area = "img";

$html = file_get_html($domain);
$scopes = $html->find($area);
foreach($scopes as $key => $scope){
    $src = $scope->src;
    $folderSave = 'kingbay-tiendo/'.basename($src);
    file_put_contents($folderSave, file_get_contents($src));
    echo $src;
    echo "<hr>";
}
?>
