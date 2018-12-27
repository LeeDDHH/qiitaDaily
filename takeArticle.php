<?php
require_once './Common.php';
require_once './getArticle.php';

//値の初期化
$title = NOTITLE;
$tags = [];
$categorizeTagsArray = [];
$noKeywordArray = [];
$largeClass = NOCLASS;
$subKeyword = '';
$replaceArray = [];

$url = $argv[1];

$apiSearch = convertURL2QiitaParameter($url);

//qiitaのapiから記事の情報を取得
$data = getArticleInfo($apiSearch);

$replaceArray['USER_ID'] = $data->user->id;
$title = $replaceArray['TITLE'] = $data->title;
$tags = $replaceArray['TAGS'] = $data->tags;
$replaceArray['RENDERED_BODY'] = $data->rendered_body;
$replaceArray['CSSFILE'] = CSSFILE;

//タイトルに/があるとディレクトリの区切りとして認識するため、&に変更
$title = str_replace('/', '&', $title);

if (!empty($tags))
{
    //タグ一覧として事前に用意した配列を読み込む
    require_once './qiitaTagArray.php';

    //文字列から取得したタグとタグ一覧のキーワードと比較する
    foreach ($tags as $tagKey => $tagValue)
    {
        //記事のtagとQiita内のtagを小文字にして比較
        $tagIndex = array_search(strtolower($tagValue->name), array_map('strtolower', $qiitaTagArray));

        //あった場合、カテゴライズするための配列にindexとタグ名を入れる
        if ($tagIndex)
        {
            $categorizeTagsArray[] = [
                                    'index' => $tagIndex,
                                    'tag_name' => $qiitaTagArray[$tagIndex]
                                ];
        }
        else
        {
            //タグ一覧に無いものは別の配列に入れる
            $noKeywordArray[] = [
                                    'tag_name' => $tagValue->name
                                ];
        }
    }

    //タグ一覧に無いものは、カテゴライズの配列の後ろに入れる
    if (!empty($noKeywordArray))
    {
        $lastKey = end($categorizeTagsArray);
        $lastIndex = $lastKey["index"];
        foreach ($noKeywordArray as $noKey => $noValue)
        {
            $lastIndex++;
            $categorizeTagsArray[] = [
                                    'index' => $lastIndex,
                                    'tag_name' => $noValue['tag_name']
                                ];
        }
    }

    //カテゴライズの配列をindexの昇順にするために揃える
    foreach ($categorizeTagsArray as $key => $row)
    {
        //indexの配列
        $categoryIndexArray[$key]  = $row['index'];
        //タグの配列
        $categoryKeywordArray[$key]  = $row['tag_name'];
    }

    //tagをindexの昇順に変更
    array_multisort($categoryIndexArray, SORT_ASC, $categorizeTagsArray);

    //tagの一番最初の値をディレクトリ名にする
    $largeClass = $categorizeTagsArray[0]['tag_name'] . '/';
    //他のタグは記事のタイトルの後ろにつけられるように代入
    $subKeyword = $subKeyword !== "" ? $subKeyword : '(' . implode(',', array_values($categoryKeywordArray)) . ')';
}

//ディレクトリがなければ生成
if (!file_exists(ARTICLE_DIR . $largeClass))
{
    mkdir(ARTICLE_DIR . $largeClass,0777,true);
}

$articleFile = getArticleHTML($url);

file_put_contents(ARTICLE_DIR . $largeClass . $title . $subKeyword . EXTENSION, $articleFile);
