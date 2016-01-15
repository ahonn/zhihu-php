<?php

/**
 * 测试 Collection 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$collection_url = 'https://www.zhihu.com/collection/19650606';

$collection = new Collection($collection_url);

// 获取收藏夹名称
$title = $collection->title();
var_dump($title);

// 获取收藏夹简介
$description = $collection->description();
var_dump($description);

// 获取收藏夹建立者
$author = $collection->author();
var_dump($author);

// 获取收藏夹内容
$answer_list = $collection->answers();
foreach ($answer_list as $answer) {
	var_dump($answer);
}

$time->stop();
echo "\nTime:" . $time->spent();