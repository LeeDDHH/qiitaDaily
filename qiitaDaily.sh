#!/bin/zsh
#Common.phpのARTICLE_DIRとDOWNLOADをつなげ、ダウンロードした投稿のパラメータを保存するファイルが読み込めるように指定
#ex)../../Documents/archive/qiita/download.txt
download=""

php ./makeTempfile.php
cat $download | while read line
do
  php takeArticle.php $line
  echo "( ˘ω˘ )スヤー "
  sleep 5
  echo "(ﾟдﾟ)ﾊｯ!"
done
echo "投稿のカテゴライズが終わりました。"
