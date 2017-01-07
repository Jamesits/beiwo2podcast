# beiwo2podcast

[被窝声次元](http://www.beiwo.ac)转换到 iTunes 兼容 Podcast (RSS 2.0) 格式的程序。

测试服务器：[https://lab.swineson.me/lab/beiwo2podcast/](https://lab.swineson.me/lab/beiwo2podcast/)

## 警告

 * 本程序不对读取到的第三方数据做任何过滤，请仅在信任数据来源的情况下使用，并且注意潜在的安全风险。
 * 本程序使用了私有 API。这意味着本程序可能随时失效，或者显示不可预料的数据。
 * 测试服务器仅供程序开发阶段测试使用，不保证长期有效，也请不要滥用。

## 已知问题

 * iTunes 对部分 feed 无法正确读取单集信息
 * 对于未上传任何音频的用户，会读取到不正确的元数据（这是被窝的 bug）
 * 没有缓存，建议使用第三方订阅服务订阅作为缓存使用

## 使用方法

传统方式：
 1. 下载代码
 2. 部署在支持 PHP 的任何服务器的任何位置
 3. 配置 config.php，填写必要信息
 4. 访问 index.php

Docker 方式：
 1. 下载代码
 2. `docker build .`
 3. `docker run` 对应的镜像
 4. 访问镜像的 80 端口

或者使用 Docker Hub 镜像：[https://hub.docker.com/r/jamesits/beiwo2podcast/]()

需要 PHP 带有 cURL 支持。支持 SAE 等程序目录不可写的服务器。

## 作者

[James Swineson](https://swineson.me)

## 感谢

 * [被窝声次元](http://www.beiwo.ac)
 * [aaronsnoswell/itunes-podcast-feed](https://github.com/aaronsnoswell/itunes-podcast-feed)
 * [php-curl-class/php-curl-class](https://github.com/php-curl-class/php-curl-class)

## 参考资料

 * [A list of the current iTunes podcast categories - in YAML format](https://gist.github.com/skattyadz/814315)
 * [iTunes - Podcasts - Making a Podcast](https://www.apple.com/itunes/podcasts/specs.html#rss)
 * [RSS 2.0 Specification](http://cyber.law.harvard.edu/rss/rss.html)
 * [Cast Feed Validator](http://castfeedvalidator.com/)
 * [gPodder Podcast Feed Best Practice](https://github.com/gpodder/podcast-feed-best-practice/blob/master/podcast-feed-best-practice.md)
