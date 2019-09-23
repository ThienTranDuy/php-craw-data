<?php
require "./simplehtmldom_1_9/simple_html_dom.php";

$domain = "http://nava.maxwebsite.vn/tuyen-dung/";
$area = "img";

$html = file_get_html($domain);
$scopes = $html->find($area);
foreach($scopes as $key => $scope){
    $src = $scope->src;
    $folderSave = 'tuyen-dung/'.basename($src);
    file_put_contents($folderSave, file_get_contents($src));
    echo $src;
    echo "<hr>";
}
?>
