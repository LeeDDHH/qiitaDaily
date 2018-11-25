<?php
require_once './getResource.php';
require_once './getArticle.php';

//値の初期化
$log = ARTICLE_DIR . ARTICLE_LOG;
$newArticle = ARTICLE_DIR . DOWNLOAD;

//今まで取得したURLの一覧のファイルがなければ生成
if (!file_exists($log))
{
    touch($log);
}
//今回取得したURL一覧のファイルがなければ生成
if (!file_exists($newArticle))
{
    touch($newArticle);
}

$apiSearch = convertURL2QiitaParameter(ARTICLE_ADDRESS);
$data = getArticleInfo($apiSearch);

//ファイルオープン
$na = fopen($newArticle, 'w');

//$articleFileはget-resource.phpで取得したファイル
//文字列からいい感じに分割し、配列にする
$articleFile = explode('位 <a href="', $articleFile);

//配列から必要な情報（タイトルとタグ）を取得
foreach ($articleFile as $k => $v)
{
    //正規表現を使っていい感じにURLを取る
    preg_match('/https:\/\/qiita.com\/([a-zA-z0-9-\/]*)"/', $v, $match);
    //該当するものがあった場合
    if (!empty($match))
    {
        //URLの後ろのダブルクォーテーションを除く
        $address = str_replace('"', '', $match[0]);
        //今まで取得したURLの一覧をオープン
        $l = fopen($log, 'r+');
            //一覧の最後の行に至るまで処理を続ける
            while (!feof($l))
            {
                //一行読み込む
                $tmp = fgets($l);
                //取得した一行から改行を除く
                $tmp = str_replace(PHP_EOL, '', $tmp);
                //URLがすでに取得したものだったら処理を終了させる
                if ($tmp == $match[1])
                {
                    break;
                }
                //最後の行まで読みんでもなかった場合
                if (feof($l))
                {
                    //今まで取得したURL一覧に記載
                    fwrite($l, $match[1]."\n");
                    //今回取得したURL一覧に記載
                    fwrite($na, $address."\n");
                }
            }
        //処理が終わったら、ファイルを閉じる
        fclose($l);
    }
}
//処理が終わったら、ファイルを閉じる
fclose($na);
