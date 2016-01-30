<?php

/**
 * 测试 Answer 类
 */

require_once '../zhihu/zhihu.php';

$answer_url = 'https://www.zhihu.com/question/38199129/answer/79525121';

$answer = new Answer($answer_url);

// 获取回答的问题
$question = $answer->question();
var_dump($question);
	
// 获取答主
$author = $answer->author();
var_dump($author);
	
// 获取赞同数
$upvote = $answer->upvote();
var_dump($upvote);
	
// 获取回答内容
$content = $answer->content();
var_dump($content);
	
// 获取所属问题浏览数
$visit_times = $answer->visit_times();
var_dump($visit_times);
	
// 获取该答案下的评论
$comment_list = $answer->comment();
foreach ($comment_list as $comment) {
	var_dump($comment);
}

// 获取答案收藏数
$collection_num = $answer->collection_num();
var_dump($collection_num);

// 获取收藏该回答的收藏夹列表
$collections = $answer->collection();
foreach ($collections as $collection) {
	var_dump($collection);
}

// 获取点赞该回答的用户
$voters = $answer->voters();
foreach ($voters as $key => $voter) {
	var_dump($voter);
}