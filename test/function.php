<?php
require "./simplehtmldom_1_9/simple_html_dom.php";
// Thông báo
function message($num) {
	echo "Đã tải về thành công. Số lượng tải về: ".count($num);
}
// Lưu hình ở home
function saveImage($domain, $imgs) {
	foreach($imgs as $img){
		$src = $img->src;
		$folderSave = 'img/'.basename($src);
		file_put_contents($folderSave, file_get_contents($domain.$src));
		return basename($src);
	}
}
// Lưu tiêu để ở home
function saveTitle($titles) {
	foreach($titles as $title){
		return $title->innertext;
	}
}
// Lưu nội dung ở home
function saveContent($contentsItem) {
	foreach($contentsItem as $contentItem){
		return $contentItem;
	}
}
// Lưu link ở home
function saveLink($domain,$links) {
	foreach($links as $link){
		return $domain.$link->href;
	}
}

// MAIN
function getSupper($domain, $area) {
	echo "INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ";
	
	$html = file_get_html($domain);
	$scopes = $html->find($area);

	foreach($scopes as $key => $scope){
		// Xử lí hình ở home
		$imgs = $scope->find("img");
		$exportImage = saveImage($domain, $imgs);

		// Xử lí tiêu đề ở home
		$titles = $scope->find("h3 a");
		$exportTitle = saveTitle($titles);

		// Xử lí link
		$links = $scope->find(">a");
		$linkItem = saveLink($domain,$links);
		
		// Xử lí detail
		$htmlItem = file_get_html($linkItem);
		$scopesItem = $htmlItem->find("#container");
		foreach($scopesItem as $scopeItem) {
			// Xử lí tiêu đề ở detail
			$titleItem = $scopeItem->find(".ct-r .main-tit h2");
			saveTitle($titleItem);

			// Xử lí content
			$contentsItem = $scopeItem->find(".center>.ct-sp");
			$exportItem = saveContent($contentsItem);
			echo "(NULL, 1, '2019-08-16 20:51:43', '2019-08-16 20:51:43', '$exportItem', '$exportTitle', '', 'publish', 'open', 'open', '', 'tieu-de', '', '', '2019-08-16 20:51:43', '2019-08-16 20:51:43', '', 0, 'http://wp01.test/?p=11', 0, 'post', '', 0),
			(NULL, 1, '2019-08-16 20:50:29', '2019-08-16 20:50:29', '', '18-CONTACTUS-HEADER', '', 'inherit', 'open', 'closed', '', '18-contactus-header', '', '', '2019-08-16 20:50:29', '2019-08-16 20:50:29', '', 11, 'http://wp01.test/wp-content/uploads/2019/08/18-CONTACTUS-HEADER.jpg', 0, 'attachment', 'image/jpeg', 0),
			(NULL, 1, '2019-08-16 20:51:11', '2019-08-16 20:51:11', '', '".$exportImage."', '', 'inherit', 'open', 'closed', '', '".$exportImage."', '', '', '2019-08-16 20:51:20', '2019-08-16 20:51:20', '', 11, 'http://wp01.test/wp-content/uploads/2019/08/".$exportImage."', 0, 'attachment', 'image/jpeg', 0),
			(NULL, 1, '2019-08-16 20:51:43', '2019-08-16 20:51:43', '$exportItem', '$exportTitle', '', 'inherit', 'closed', 'closed', '', '11-revision-v1', '', '', '2019-08-16 20:51:43', '2019-08-16 20:51:43', '', 11, 'http://wp01.test/index.php/2019/08/16/11-revision-v1/', 0, 'revision', '', 0);
			";
		}
	}
	// message($scopes);
}