<?php
/**
 * beiwo2podcast
 * https://github.com/Jamesits/beiwo2podcast
 * @author James Swineson
 * 2015-07-19
*/
$version = '1.5';
$php_curl_class_version = '3.6.7';

// 安装目录
// 手工设置
// $install_path = 'http://lab.swineson.me/lab/beiwo2podcast/';
function endsWith($haystack, $needle) {
    // http://stackoverflow.com/a/10473026/2646069
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}
$install_path = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (endsWith($install_path, ".php")) $install_path = dirname($install_path) . '/';
// 是否显示那个测试服务器的提示
$isDevelopingServer = true;
// 默认一次读取的单集数
$default_limit = 30;
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
