<?php

/**
 * 测试 Topic 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$topic_url = 'https://www.zhihu.com/topic/19606711';

$topic = new Topic($topic_url);

// 获取话题名称
$name = $topic->get_name();
var_dump($name);

// 获取话题描述
$description = $topic->get_description();
var_dump($description);

// 获取话题关注人数
$followers_num = $topic->get_followers();
var_dump($followers_num);

// 获取父话题
$parent = $topic->get_parent();
var_dump($parent);

// 获取子话题
$children = $topic->get_children();
var_dump($children);

// 获取最佳回答者
$answerer = $topic->get_answerer();
var_dump($answerer);

// 获取该话题下的热门问题
$hot_question = $topic->get_hot_question();
var_dump($hot_question);
	
// 获ge取该话题下排名靠前的问题
$top_question = $topic->get_top_question();
var_dump($top_question);

// 获取该话题下最新的问题
$new_question = $topic->get_new_question();
var_dump($new_question);

$time->stop();
echo "\nTime:" . $time->spent();