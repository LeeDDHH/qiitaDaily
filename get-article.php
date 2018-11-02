<?php
require_once('./Common.php');
//qiitaのapiから記事の情報を取得
function getArticleInfo($arg) :stdClass{
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
    $data = json_decode($json);
    return $data;
}

//urlからhtmlそのままクローリング
function getArticleHTML($url) :string {
    //ユーザーエージェントを記載
    $options = array(
    'https' => array(
        'method' => 'GET',
        'header' => USERAGENT,
    ),
    );
    $context = stream_context_create($options);

    //htmlを持ってきて文字列にする
    $articleFile = file_get_contents($url,false, $context);
    return $articleFile;
}
?>
