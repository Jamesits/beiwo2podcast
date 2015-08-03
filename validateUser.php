<?php
/**
 * beiwo2podcast
 * https://github.com/Jamesits/beiwo2podcast
 * @author James Swineson
 * 2015-08-03
*/
require_once('config.php');
require_once('Curl/Curl.php');
use \Curl\Curl;

header('charset=utf-8');

if (!isset($_GET['id']) || $_GET['id'] == '') die('{"result": false}');
$userid = $_GET['id'];
$limit = (isset($_GET['limit']) && intval($_GET['limit']) > 0) ? intval($_GET['limit']) : $default_limit;

$curl = new Curl();
$curl->setUserAgent($ua);
$curl->setOpt(CURLOPT_ENCODING , 'gzip');
$curl->get('http://www.beiwo.ac/users/myPageDataWithPaging', array(
    'id' => $userid,
    'limit' => $limit,
    'curItems' => 0,
));
if ($curl->error) {
    die('错误 ' . $curl->error_code . '：' . $curl->error_message);
}

$userdata = json_decode($curl->response, true);
if (count($userdata['items']) == 0) echo '{"result": false}'; else  echo '{"result": true}';
?>
