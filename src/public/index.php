<?php
$file = 'top.html';
if (file_exists($file)) {
    $content = file_get_contents($file);
    if ($content === false) {
        echo 'ファイルの読み込みに失敗しました。';
    } else {
        echo $content;
    }
} else {
    echo 'ファイルが見つかりません。';
}
?>
