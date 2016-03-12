<?php

echo '<h1>PHPキャンプのアプリ一覧</h1>';

foreach(glob('*') as $dir){
    if(is_dir($dir)){
        echo '<li><a href="./' . $dir . '">' . $dir . '</a></li>';
    }
}