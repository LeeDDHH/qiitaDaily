<?php
require_once './Common.php';
//qiitaのapiから記事の情報を取得

/**
 * Undocumented function
 *
 * @param string $arg
 * @return stdClass
 */
function getArticleInfo(string $arg): stdClass
{
    // curlの初期化
    $ch = curl_init();

    // curlのオプション設定
    $options = array(
        CURLOPT_URL => $arg,
        CURLOPT_HTTPHEADER => array(
            // データの形式、文字コード記載
            'Content-Type: application/json; charser=UTF-8',
            // 自身のアクセストークン
            'Authorization: Bearer ' . ACCESSTOKEN,
        ),
        // 返り値を文字列で取得
        CURLOPT_RETURNTRANSFER => true,
        // HTTPメソッド指定
        CURLOPT_CUSTOMREQUEST => 'GET',
    );
    // 複数のオプションを設定
    curl_setopt_array($ch, $options);
    // curlの実行
    $json = curl_exec($ch);

    // curlを閉じる
    curl_close($ch);
    // json文字列をデコード
    return json_decode($json);
}

/**
 * Undocumented function
 *
 * @param string $url
 * @return string
 */
//urlからhtmlそのままクローリング
function getArticleHTML(string $url): string
{
    //ユーザーエージェントを記載
    $options = array(
        'https' => array(
            'method' => 'GET',
            'header' => USERAGENT,
        ),
    );
    $context = stream_context_create($options);

    //htmlを持ってきて文字列にする
    return file_get_contents($url, false, $context);
}

/**
 * Undocumented function
 *
 * @param string $url
 * @return string
 */
function convertURL2QiitaParameter(string $url): string
{
    // 使用するURL
    preg_match('/https:\/\/qiita.com\/([a-zA-Z0-9\/"\'_<>\（\）\(\)=\n\r !+\-#.]*)\/items\/([a-zA-Z0-9]*)/', $url, $arg);

    return 'https://qiita.com/api/v2/items/' . $arg[2];
}

/**
 * Undocumented function
 *
 * @param array $array
 * @return string
 */
function convertTemplate(array $array): string
{
    $contentsReplaceArray = [];
    $contentsIndexArray = ['USER_ID','TITLE','TAGS','RENDERED_BODY','CSSFILE'];
    $contents = file_get_contents(dirname ( __FILE__ ) . TEMPLATE);
    foreach($array as $k => $v)
    {
        switch($k)
        {
            case 'TAGS':
                foreach($array['TAGS'] as $k => $v)
                {
                    $tags .= '<a class="it-Tags_item" href="/tags/' . $v->name . '"><span>' . $v->name . '</span></a>';
                }
                $contentsReplaceArray['TAGS'] = $tags;
                break;

            default:
                $contentsReplaceArray[$k] = $array[$k];
                break;
        }
    }

    foreach ($contentsReplaceArray as $key=>$val)
    {
        $contents = str_replace(REPLACE_SYMBOL . $key . REPLACE_SYMBOL, $val, $contents);
    }
    return $contents;
}
