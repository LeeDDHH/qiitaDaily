<?php
define('ARTICLE_ADDRESS', 'https://qiita.com/takeharu/items/bb154a4bc198fb102ff3');//デイリーランキング,ウィークリランキングを取得するためのURL
define('ARTICLE_DIR', '');//保存先のパスを指定してください
define('TEMP_DIR', '');//ARTICLE_ADDRESSで取ったhtmlを一時保存するためのパス
define('ARTICLE_LOG', 'articleLog.txt');//今まで取得した投稿のパラメータを保存するファイル
define('DOWNLOAD', 'download.txt');//クロールしたとき、ダウンロードした投稿のパラメータを保存するファイル
define('TEMP_FILE', 'temp.html');//ARTICLE_ADDRESSで取ったhtmlの一時保存ファイル
define('EXTENSION','.html');//投稿ファイルの拡張子
define('NOTITLE','無題の投稿');//デフォルトの投稿ファイル名
define('NOCLASS','noClass/');//デフォルトのカテゴリ名
define('USERAGENT','');//userAgentを指定
define('ACCESSTOKEN','');//qiitaの開発者向けのアクセストークンを入れてください
?>
