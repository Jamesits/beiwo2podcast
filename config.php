<?php
/**
 * beiwo2podcast
 * https://github.com/Jamesits/beiwo2podcast
 * @author James Swineson
 * 2015-07-19
*/
$version = '1.5';
$php_curl_class_version = '3.6.7';

// 安装目录（包括结尾斜杠）
$install_path = 'http://lab.swineson.me/lab/beiwo2podcast/';
// 是否显示那个测试服务器的提示
$isDevelopingServer = true;
// 默认一次读取的单集数
$default_limit = 16;
// 是否含有成人内容（'clean' or 'no'）
$default_explicit = 'clean';
// 默认一级分类
$default_category = 'Arts';
// 默认二级分类
$default_subcategory = 'Performing Arts';

$ua = 'beiwo2podcast/'.$version;
if ($isDevelopingServer) $ua .= '-develop';
$ua .= ' (+https://github.com/Jamesits/beiwo2podcast)';
$ua .= " PHP-Curl-Class/$php_curl_class_version (+https://github.com/php-curl-class/php-curl-class)";
$ua .= ' PHP/' . PHP_VERSION;
$curl_version = curl_version();
$ua .= ' cURL/' . $curl_version['version'];
?>
