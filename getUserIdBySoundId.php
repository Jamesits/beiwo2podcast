<?php
/**
 * beiwo2podcast
 * https://github.com/Jamesits/beiwo2podcast
 * @author James Swineson
 * 2015-07-19
*/
require_once('config.php');
require_once('Curl/Curl.php');
use \Curl\Curl;

header('charset=utf-8');

$id = $_GET['id'];

$curl = new Curl();
$curl->setUserAgent($ua);
$curl->setOpt(CURLOPT_ENCODING , 'gzip');
$curl->get('http://www.beiwo.ac/users/getSoundByIdWithAjax', array(
    'id' => $id,
    'code' => 0,
));
if ($curl->error) {
    die('错误 ' . $curl->error_code . '：' . $curl->error_message);
}
$songdata0 = json_decode($curl->response, true);
$userid = $songdata0['items'][0]['user']['objectId'];
echo '{"soundId": "'.$id.'", "userId": "'.$userid.'"}';
?>
