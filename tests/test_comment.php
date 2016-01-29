<?php
/**
 * 测试 Comment 类
 */
require_once '../src/zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$answer_url = 'https://www.zhihu.com/question/19550393/answer/12202130';

$answer = new Answer($answer_url);

// 获取该回答的评论
$comments = $answer->comment();
foreach ($comments as $comment) {
	var_dump($comment);

	// 获取评论作者
	$author = $comment->author();
	var_dump($author);

	// 获取被回复者
	$replyed = $comment->replyed();
	var_dump($replyed);

	// 获取评论内容
	$content = $comment->content();
	var_dump($content);

	// 获取评论时间
	$time = $comment->time();
	var_dump($time);
}

