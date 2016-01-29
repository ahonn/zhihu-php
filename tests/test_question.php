<?php

/**
 * 测试 Question 类
 */

require_once '../src/zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$question_url = 'https://www.zhihu.com/question/38813693';

$question = new Question($question_url);

// // 获取问题标题
// $title = $question->title();
// var_dump($title);

// // 获取问题描述，返回字符串
// $detail_str = $question->detail();
// var_dump($detail_str);

// // 获取问题话题标签
// $topics = $question->topics();
// var_dump($topics);

// // 获取问题关注数
// $followers_num = $question->followers_num();
// var_dump($followers_num);

// // 获取关注该问题的用户
// $followers_list = $question->followers();
// foreach ($followers_list as $followers) {
// 	var_dump($followers);
// }

// // 获取问题回答数
// $answers_num = $question->answers_num();
// var_dump($answers_num);

// 获取问题的所有回答
$answers = $question->answers();
foreach ($answers as $answer) {
	var_dump($answer);
}

// // 获取该问题排名Top n的答案
// $answer = $question->top_answer(5);
// var_dump($answer);
	
// // 获取问题被浏览数
// $times = $question->visit_times();
// var_dump($times);

$time->stop();
echo "\nTime:" . $time->spent();