<?php
/**
* beiwo2podcast
* https://github.com/Jamesits/beiwo2podcast
* @author James Swineson
* 2015-07-19
*/
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>beiwo2podcast</title>
  <?php require('assets/bootstrap_provider.php'); ?>
  <link rel="stylesheet" href="assets/index.css">
  <script>var install_path = '<?php echo $install_path; ?>';</script>
  <script src="assets/index.js"></script>
</head>
<body>
  <a href="https://github.com/Jamesits/beiwo2podcast"><img style="position: absolute; top: 0; right: 0; border: 0;" src="assets/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub" data-canonical-src="assets/forkme_right_gray_6d6d6d.png"></a>
  <div class="container">
    <div class="jumbotron">
      <h1>beiwo2podcast</h1>
      <p><a href="http://www.beiwo.ac">被窝声次元</a>转换到 iTunes 兼容 Podcast (RSS 2.0) 格式的程序。</p>
      <p>Version <?php echo $version; ?> by <a href="https://swineson.me">James Swineson</a>, <a href="https://github.com/Jamesits/beiwo2podcast">Github Repository</a></p>
    </div>
    <div class="alert alert-info" role="alert">
      <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
      本程序不对读取到的第三方数据做任何过滤，请仅在信任数据来源的情况下使用，并且注意潜在的安全风险。
    </div>
    <div class="alert alert-info" role="alert">
      <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
      本程序使用了私有 API。这意味着本程序可能随时失效，或者显示不可预料的数据。
    </div>
    <?php if ($isDevelopingServer == true) {?>
    <div class="alert alert-warning" role="alert">
      <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
      <strong>注意！</strong> 这是一台测试服务器，仅供程序开发阶段测试使用，不保证长期有效，也请不要滥用。如果需要稳定的服务，你可以<a href="https://github.com/Jamesits/beiwo2podcast">自行部署</a>。
    </div>
    <?php } ?>
    <form id="formconvert">
      <div class="input-group">
        <input id="fromurl" type="text" class="form-control" placeholder="在这里粘贴用户主页或音频的 URL...">
        <span class="input-group-btn">
          <button id="btnsend" class="btn btn-default" type="submit">转换为 RSS</button>
        </span>
      </div>
    </form>
    <div class="panel panel-success" style="display: none;">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <h3 class="panel-title">转换成功</h3>
      </div>
      <div class="panel-body">
        RSS Feed 地址：<span class="well well-sm feedurl">http://example.com</span>
        你现在可以使用通用型 Podcast 客户端订阅它了。
      </div>
    </div>
    <div class="panel panel-danger" style="display: none;">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        <h3 class="panel-title">转换失败</h3>
      </div>
      <div class="panel-body">
        <span class="errormsg"></span>
      </div>
    </div>
    <div class="panel panel-warning" style="display: none;">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
        <h3 class="panel-title">注意</h3>
      </div>
      <div class="panel-body">
          RSS Feed：<span class="well well-sm feedurl">http://example.com</span>
          你现在可以使用通用型 Podcast 客户端订阅它了。
          <span class="errormsg"></span>
      </div>
      </div>
      <footer class="footer">
        <p><?php echo $ua; ?></p>
      </footer>
    </div>
  </body>
  </html>
