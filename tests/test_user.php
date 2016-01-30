<?php

/**
 * 测试 User 类
 */

require_once '../zhihu/zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

$user_url = 'https://www.zhihu.com/people/ahonn';

$user = new User($user_url);

// 获取用户信息
$about = $user->about();
echo($about['name']."\n");
echo($about['avatar']."\n");
echo($about['location']."\n");
echo($about['business']."\n");
echo($about['gender']."\n");
echo($about['employment']."\n");
echo($about['position']."\n");
echo($about['education']."\n");
echo($about['major']."\n");
echo($about['desc']."\n");

// 获取用户关注数
$followees_num = $user->followees_num();
echo($followees_num."\n");
	
// 获取用户粉丝数
$followers_num = $user->followers_num();
echo($followers_num."\n");
	
// 获取用户获得的赞同数
$agree_num = $user->agree_num();
echo($agree_num."\n");

// 获取用户获得感谢数
$thanks_num = $user->thanks_num();
echo($thanks_num."\n");

// 获取用户问题提问数
$asks_num = $user->asks_num();
echo($asks_num."\n");

// 获取用户问题回答数
$answer_num = $user->answers_num();
echo($answer_num."\n");

// 获取用户专栏文章数
$posts_num = $user->posts_num();
echo($posts_num."\n");

// 获取用户收藏数
$collection_num = $user->collections_num();
echo($collection_num."\n");
	
	
// 获取用户关注话题数
$topics_num = $user->topics_num();
echo($topics_num."\n");
	
// 获取用户关注话题列表
$topic_list = $user->topics();
foreach ($topic_list as $topic) {
	echo($topic->name()."\n");
}

// 获取用户关注列表
$followees_list = $user->followees();
foreach ($followees_list as $followees) {
	echo($followees->name()."\n");
}
	
// 获取用户粉丝列表
$followers_list = $user->followers();
foreach ($followers_list as $followers) {
	echo($followers->name()."\n");
}
	
// 获取用户提问列表
$asks_list = $user->asks();
foreach ($asks_list as $asks) {
	echo($asks->title()."\n");
}
	
// 获取用户回答列表
$answer_list = $user->answers();
foreach ($answer_list as $answer) {
	echo($answer->question()->title()."\n");
}

// 获取用户收藏夹列表
$collections = $user->collections();
foreach ($collections as $collection) {
	echo($collection->title()."\n");
}

$time->stop();
echo "\nTime:" . $time->spent();