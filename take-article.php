<?php
require_once('./Common.php');
require_once('./get-article.php');

//値の初期化
$title = NOTITLE;
$tags = array();
$categorizeTagsArray = array();
$noKeywordArray = array();
$largeClass = NOCLASS;
$subKeyword = '';

$url = $argv[1];

// 使用するURL
preg_match('/https:\/\/qiita.com\/([a-zA-Z0-9\/"\'_<>\（\）\(\)=\n\r !+\-#.]*)\/items\/([a-zA-Z0-9]*)/', $url, $arg);

$apiSearch = 'https://qiita.com/api/v2/items/' . $arg[2];

//qiitaのapiから記事の情報を取得
$data = getArticleInfo($apiSearch);

$title = $data->title;
$tags = $data->tags;

if(!empty($tags)){
    //タグ一覧として事前に用意した配列を読み込む
    require_once('./qiitaTagArray.php');

    //文字列から取得したタグとタグ一覧のキーワードと比較する
    foreach($tags as $tagKey => $tagValue){
        //記事のtagとQiita内のtagを小文字にして比較
        $tagIndex = array_search(strtolower($tagValue->name), array_map('strtolower', $qiitaTagArray));

        //あった場合、カテゴライズするための配列にindexとタグ名を入れる
        if($tagIndex){
            $categorizeTagsArray[] = [
                                    'index' => $tagIndex,
                                    'tag_name' => $qiitaTagArray[$tagIndex]
                                ];
        } else {
            //タグ一覧に無いものは別の配列に入れる
            $noKeywordArray[] = [
                                    'tag_name' => $tagValue->name
                                ];
        }
    }

    //タグ一覧に無いものは、カテゴライズの配列の後ろに入れる
    if(!empty($noKeywordArray)){
        $lastKey = end($categorizeTagsArray);
        $lastIndex = $lastKey["index"];
        foreach($noKeywordArray as $noKey => $noValue){
            $lastIndex++;
            $categorizeTagsArray[] = [
                                    'index' => $lastIndex,
                                    'tag_name' => $noValue['tag_name']
                                ];
        }
    }

    //カテゴライズの配列をindexの昇順にするために揃える
    foreach ($categorizeTagsArray as $key => $row) {
        //indexの配列
        $index[$key]  = $row['index'];
        //タグの配列
        $keyword[$key]  = $row['tag_name'];
    }

    //tagをindexの昇順に変更
    array_multisort($index, SORT_ASC,$categorizeTagsArray);

    //tagの一番最初の値をディレクトリ名にする
    $largeClass = $categorizeTagsArray[0]['tag_name'] . '/';
    //他のタグは記事のタイトルの後ろにつけられるように代入
    $subKeyword = $subKeyword !== "" ? $subKeyword : '(' . implode(',', array_values($keyword)) . ')';
}

//ディレクトリがなければ生成
if(!file_exists(ARTICLE_DIR . $largeClass)){
    mkdir(ARTICLE_DIR . $largeClass,0777,true);
}

$articleFile = getArticleHTML($url);

file_put_contents(ARTICLE_DIR . $largeClass . $title . $subKeyword . EXTENSION, $articleFile);
?>
