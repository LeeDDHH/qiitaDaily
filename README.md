# qiitaDaily
ローカルにqiita記事をカテゴライズして保存

### 使い方

### 事前に指定しておくこと
⚠️使用する前に`Common.php`と`qiitaDaily.sh`にて以下の値を設定してください。

`Common.php`
- ARTICLE_DIR：　投稿の保存先 ex)../../Documents/archive/qiita/
- TEMP_DIR：　tempファイルの保存先 ex)../../Documents/archive/qiita/temp/
- USERAGENT：　userAgent ex)User-Agent: Bot/1.0 (◯◯Bot; rev.20181108; ◯◯@gmail.com)
- ACCESSTOKEN：　qiitaの開発者用アクセストークン

`qiitaDaily.sh`
- download：　Common.phpで指定した「ダウンロードした投稿のパラメーターを保存するファイル」までのパス ex)../../Documents/archive/qiita/download.txt

### 実行例
```
sh qiitaDaily.sh
```

### 補足
qiitaDaily.shに指定されたsleepの値は少なくとも1以上にしておいてください。
