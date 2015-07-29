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

/**
 * Returns the size of a file without downloading it, or -1 if the file
 * size could not be determined.
 *
 * @param $url - The location of the remote file to download. Cannot
 * be null or empty.
 *
 * @return The size of the file referenced by $url, or -1 if the size
 * could not be determined.
 *
 * from: https://stackoverflow.com/questions/2602612/php-remote-file-size-without-downloading-file
 */
function curl_get_file_size( $url ) {
  // Assume failure.
  $result = -1;

  $curl = curl_init( $url );

  // Issue a HEAD request and follow any redirects.
  curl_setopt( $curl, CURLOPT_NOBODY, true );
  curl_setopt( $curl, CURLOPT_HEADER, true );
  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
  curl_setopt( $curl, CURLOPT_USERAGENT, $ua );

  $data = curl_exec( $curl );
  curl_close( $curl );

  if( $data ) {
    $content_length = "unknown";
    $status = "unknown";

    if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
      $status = (int)$matches[1];
    }

    if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
      $content_length = (int)$matches[1];
    }

    // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    if( $status == 200 || ($status > 300 && $status <= 308) ) {
      $result = $content_length;
    }
  }

  return $result;
}

// https://stackoverflow.com/questions/2236873/getting-the-full-url-of-the-current-page-php
function selfURL()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}

function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

// from: https://stackoverflow.com/questions/3431280/validation-failed-entityref-expecting
function encodeHtmlEntitiesForXmlAttribute($s) {return str_replace('&', '&amp;', $s);}

if (!isset($_GET['id']))
    die('错误：缺少用户 ID');
$userid = $_GET['id'];
$limit = (isset($_GET['limit']) && intval($_GET['limit']) > 0) ? intval($_GET['limit']) : $default_limit;
$explicit = isset($_GET['explicit'])? $_GET['explicit'] : $default_explicit;
$category = isset($_GET['category'])? $_GET['category'] : $default_category;
$subcategory = isset($_GET['subcategory'])? $_GET['subcategory'] : $default_subcategory;

// get all useful metadata
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
$listdata = json_decode($curl->response, true);
$episodes = $listdata['items'];

$curl->get('http://www.beiwo.ac/users/getSoundByIdWithAjax', array(
    'id' => $episodes[0]['objectId'],
    'code' => 0,
));
if ($curl->error) {
    die('错误 ' . $curl->error_code . '：' . $curl->error_message);
}
$songdata0 = json_decode($curl->response, true);
$userdata = $songdata0['user'];

// feed metadata vars
$feed_title = $userdata['nickName'].' - 被窝声次元';
$feed_link = "http://www.beiwo.ac/users/my?id=".$userid;
$feed_description = $userdata['mark'];
$feed_copyright = 'Copyright 2014-'.date("Y").' beiwo.ac Inc. All rights reserved.';
$feed_ttl = 60 * 60 * 24;
$feed_lang = "zh-cn";
$feed_self_uri = selfURL();

// iTunes specific metadata vars
$feed_author = $userdata['nickName'];
$feed_email = $userdata['email'];
$feed_image = $userdata['photo']['_url'];
$feed_explicit = $explicit;
$feed_category = $category;
$feed_subcategory = $subcategory;

// start output XML
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<!-- Auto generated by beiwo2podcast v<?php echo $version; ?> . https://github.com/Jamesits/beiwo2podcast -->
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title><![CDATA[<?php echo $feed_title; ?>]]></title>
        <link><![CDATA[<?php echo $feed_link; ?>]]></link>
        <atom:link href="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_self_uri); ?>" rel="self" type="application/rss+xml"/>
        <generator><![CDATA[beiwo2podcast/<?php echo $version; ?> (+https://github.com/Jamesits/beiwo2podcast)]]></generator>
        <itunes:new-feed-url><![CDATA[<?php echo $feed_self_uri; ?>]]></itunes:new-feed-url>
        <itunes:author><![CDATA[<?php echo $feed_author; ?>]]></itunes:author>
        <itunes:owner>
            <itunes:name><![CDATA[<?php echo $feed_author; ?>]]></itunes:name>
            <itunes:email><![CDATA[<?php echo $feed_email; ?>]]></itunes:email>
        </itunes:owner>
        <itunes:image href="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_image); ?>" />
        <itunes:explicit><?php echo encodeHtmlEntitiesForXmlAttribute($feed_explicit); ?></itunes:explicit>
        <itunes:category text="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_category); ?>">
            <itunes:category text="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_subcategory); ?>" />
        </itunes:category>
        <itunes:summary><![CDATA[<?php echo $feed_description; ?>]]></itunes:summary>
        <category>Music</category>
        <description><![CDATA[<?php echo $feed_description; ?>]]></description>
        <language><?php echo $feed_lang; ?></language>
        <copyright><![CDATA[<?php echo $feed_copyright; ?>]]></copyright>
        <ttl><?php echo $feed_ttl; ?></ttl>

        <?php
        foreach ($episodes as $e) {
                $title = $e['title'];
                $url = $e['sound']['url'];
                $author = $feed_author;
                $duration = gmdate("H:i:s", $e['length']);
                $description = $e['content'];
                $date = date(DateTime::RFC2822, strtotime($e['createdAt']));
                $size = curl_get_file_size($url); if ($size < 0) $size = 0;
                $link = 'http://www.beiwo.ac/users/audioIndexPc?id='. $e['objectId'];
                $image = $e['cover']['url'];//substr($e['cover']['url'], 0, strpos($e['cover']['url'], '?'));
        ?>
        <item>
            <title><![CDATA[<?php echo $title; ?>]]></title>
            <link><![CDATA[<?php echo $link; ?>]]></link>
            <itunes:author><![CDATA[<?php echo $author; ?>]]></itunes:author>
            <itunes:owner><![CDATA[被窝声次元]]></itunes:owner>
            <itunes:category text="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_category); ?>">
                <itunes:category text="<?php echo encodeHtmlEntitiesForXmlAttribute($feed_subcategory); ?>" />
            </itunes:category>
            <itunes:image href="<?php echo encodeHtmlEntitiesForXmlAttribute($image); ?>" />
            <itunes:summary><![CDATA[<?php echo $description; ?>]]></itunes:summary>
            <itunes:duration><?php echo $duration; ?></itunes:duration>
            <category><![CDATA[<?php echo $feed_category; ?>]]></category>
            <duration><?php echo $duration; ?></duration>
            <description><![CDATA[<?php echo $description; ?>]]></description>
            <comments><![CDATA[<?php echo $link; ?>]]></comments>
            <pubDate><?php echo $date; ?></pubDate>
            <enclosure url="<?php echo encodeHtmlEntitiesForXmlAttribute($url); ?>" length="<?php echo encodeHtmlEntitiesForXmlAttribute($size); ?>" type="audio/mpeg" />
            <guid isPermaLink="true"><![CDATA[<?php echo $link; ?>]]></guid>
        </item>
        <?php
        }
        ?>
    </channel>
</rss>
