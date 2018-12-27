<?php
define('ARTICLE_ADDRESS', 'https://qiita.com/takeharu/items/bb154a4bc198fb102ff3');//デイリーランキング,ウィークリランキングを取得するためのURL
define('ARTICLE_DIR', '');//保存先のパスを指定してください ex)../../Documents/archive/qiita/
define('TEMP_DIR', '');//ARTICLE_ADDRESSで取ったhtmlを一時保存するためのパス ex)../../Documents/archive/qiita/temp/
define('ARTICLE_LOG', 'articleLog.txt');//今まで取得した投稿のパラメータを保存するファイル
define('DOWNLOAD', 'download.txt');//クロールしたとき、ダウンロードした投稿のパラメータを保存するファイル
define('TEMP_FILE', 'temp.html');//ARTICLE_ADDRESSで取ったhtmlの一時保存ファイル
define('EXTENSION','.html');//投稿ファイルの拡張子
define('NOTITLE','無題の投稿');//デフォルトの投稿ファイル名
define('NOCLASS','noClass/');//デフォルトのカテゴリ名
define('USERAGENT','User-Agent: Bot/1.0 () ');//userAgentを指定 ex)User-Agent: Bot/1.0 (◯◯Bot; rev.20181108; ◯◯@gmail.com)
define('ACCESSTOKEN',"");//qiitaの開発者向けのアクセストークンを入れてください
define('TEMPLATE', '/template.html');//書き出し用テンプレート
define('CSSFILE', '/style-8140ff048d203c2f3495c80fc4aea450.min.css');//書き出しの様式を整えるためのcss先 ex)../../../../sh/getQiitaDaily/style-8140ff048d203c2f3495c80fc4aea450.min.css
define('REPLACE_SYMBOL', '%%');//テンプレートへ変換する文字列の区切り文字
