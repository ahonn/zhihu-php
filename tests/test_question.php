<?php

/**
 * 测试 Question 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$question_url = 'https://www.zhihu.com/question/38813693';

$question = new Question($question_url);

// 获取问题标题
$title = $question->get_title();
var_dump($title);

// 获取问题描述，返回字符串
$detail_str = $question->get_detail_str();
var_dump($detail_str);

// 获取问题描述，返回HTML
$detail_html = $question->get_detail_html();
var_dump($detail_html);

// 获取问题回答数
$answers_num = $question->get_answers_num();
var_dump($answers_num);

// 获取问题关注数
$followers_num = $question->get_followers_num();
var_dump($followers_num);

// 获取问题话题列表
$topic_list = $question->get_topics();
var_dump($topic_list);

// 获取关注该问题的用户
$followers_list = $question->get_followers();
foreach ($followers_list as $followers) {
	var_dump($followers);
}
	
// 获取问题的回答
$answer_list = $question->get_answers();
foreach ($answer_list as $answer) {
	var_dump($answer);
}

// 获取该问题排名Top n的答案
$answer = $question->get_top_answer();
var_dump($answer);
	
// 获取问题被浏览数
$times = $question->get_visit_times();
var_dump($times);

$time->stop();
echo "\nTime:" . $time->spent();