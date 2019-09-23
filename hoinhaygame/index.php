<?php
require "./simplehtmldom_1_9/simple_html_dom.php";

$domain = "https://store.steampowered.com/";
$area = "img";

$html = file_get_html($domain);
$scopes = $html->find($area);
foreach($scopes as $key => $scope){
    $src = $scope->src;
    $folderSave = 'img/'.basename($src);
    file_put_contents($folderSave, file_get_contents($src));
    echo $src;
    echo "<hr>";
}
?>
