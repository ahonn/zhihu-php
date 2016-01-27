<?php

/**
 * 测试 User 类
 */

require_once '../zhihu.php';
require_once 'time.php';

$time = new Time();
$time->star();

// $user_url = 'https://www.zhihu.com/people/excited-vczh';
$user_url = 'https://www.zhihu.com/people/ahonn';

$user = new User($user_url);

// 获取用户ID
$name = $user->name();
var_dump($name);

// 获取用户头像URL
$avatar = $user->avatar();
var_dump($avatar);

// 获取用户微博链接
$weibo_url = $user->weibo_url();
var_dump($weibo_url);

// 获取用户信息
$about = $user->about();
var_dump($about);

// 获取用户关注数
$followees_num = $user->followees_num();
var_dump($followees_num);
	
// 获取用户粉丝数
$followers_num = $user->followers_num();
var_dump($followers_num);
	
// 获取用户获得的赞同数
$agree_num = $user->agree_num();
var_dump($agree_num);

// 获取用户获得感谢数
$thanks_num = $user->thanks_num();
var_dump($thanks_num);

// 获取用户问题提问数
$asks_num = $user->asks_num();
var_dump($asks_num);

// 获取用户问题回答数
$answer_num = $user->answers_num();
var_dump($answer_num);

// 获取用户专栏文章数
$posts_num = $user->posts_num();
var_dump($posts_num);

// 获取用户收藏数
$collection_num = $user->collections_num();
var_dump($collection_num);
	
	
// 获取用户关注话题数
$topics_num = $user->topics_num();
var_dump($topics_num);
	
// 获取用户关注话题列表
$topic_list = $user->topics();
foreach ($topic_list as $topic) {
	var_dump($topic);
}

// 获取用户关注列表
$followees_list = $user->followees();
foreach ($followees_list as $followees) {
	var_dump($followees);
}
	
// 获取用户粉丝列表
$followers_list = $user->followers();
foreach ($followers_list as $followers) {
	var_dump($followers);
}
	
// 获取用户提问列表
$asks_list = $user->asks();
foreach ($asks_list as $asks) {
	var_dump($asks);
}
	
// 获取用户回答列表
$answer_list = $user->answers();
foreach ($answer_list as $answer) {
	var_dump($answer);
}

// 获取用户收藏夹列表
$collections = $user->collections();
foreach ($collections as $collection) {
	var_dump($collection->title());
}

$time->stop();
echo "\nTime:" . $time->spent();

