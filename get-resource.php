<?php
require_once('./Common.php');
require_once('./get-article.php');

$url = ARTICLE_ADDRESS;
$articleFile = getArticleHTML($url);

//ディレクトリがなければ生成
if(!file_exists(TEMP_DIR)){
    mkdir(TEMP_DIR,0777,true);
}
file_put_contents(TEMP_DIR . TEMP_FILE, $articleFile);
?>
