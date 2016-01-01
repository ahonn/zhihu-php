<?php

/**
 * 测试 Answer 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$answer_url = 'https://www.zhihu.com/question/23841579/answer/79001713';

$answer = new Answer($answer_url);

// 获取回答的问题
$question = $answer->get_question();
var_dump($question);
	
// 获取答主
$author = $answer->get_author();
var_dump($author);
	
// 获取赞同数
$upvote = $answer->get_upvote();
var_dump($upvote);
	
// 获取回答内容
$content = $answer->get_content();
var_dump($content);
	
// 获取所属问题浏览数
$visit_times = $answer->get_visit_times();
var_dump($visit_times);
	
// 获取该答案下的评论
$comment_list = $answer->get_comment();
foreach ($comment_list as $comment) {
	var_dump($comment);
}

$time->stop();
echo "\nTime:" . $time->spent();