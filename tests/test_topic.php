<?php

/**
 * 测试 Topic 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$topic_url = 'https://www.zhihu.com/topic/19552330';

$topic = new Topic($topic_url);

// 获取话题名称
$name = $topic->name();
var_dump($name);

// 获取话题描述
$description = $topic->description();
var_dump($description);

// 获取话题关注人数
$followers_num = $topic->followers();
var_dump($followers_num);

// 获取父话题
$parent = $topic->parent();
var_dump($parent);

// 获取子话题
$children = $topic->children();
var_dump($children);

// 获取最佳回答者
$answerer = $topic->answerer();
var_dump($answerer);

// 获取该话题下热门问题
$hot_question = $topic->hot_question();
foreach ($hot_question as $question) {
	var_dump($question);
}

// 获取该话题下最新问题
$new_question = $topic->new_question();
foreach ($new_question as $question) {
	var_dump($question);
}
	
// 获取该话题下精华回答
$top_answer = $topic->top_answer();
foreach ($top_answer as $answer) {
	var_dump($answer);
}

// 获取该话题下全部问题
$all_question = $topic->all_question();
foreach ($all_question as $question) {
	var_dump($question);
}

$time->stop();
echo "\nTime:" . $time->spent();