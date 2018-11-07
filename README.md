# qiita_daily
qiita記事のクローリング＆スクレイピング

## 紹介
Supporterz Colab　発表用資料

### 使い方

#### 事前に指定しておくこと
⚠️使用する前に`Common.php`と`qiita_daily.sh`にて以下の値を設定してください。

`Common.php`
- ARTICLE_DIR：　投稿の保存先
- TEMP_DIR：　tempファイルの保存先
- USERAGENT：　userAgent
- ACCESSTOKEN：　qiitaの開発者用アクセストークン

`qiita_daily.sh`
- download：　Common.phpで指定した「ダウンロードした投稿のパラメーターを保存するファイル」までのパス

#### 実行例
```
sh qiita_daily.sh
```

### 補足
qiita_daily.shに指定されたsleepの値は少なくとも1以上にしておいてください。
