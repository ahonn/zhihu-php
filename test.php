<?php

require_once 'zhihu.php';

/**
 * 	Test User 
 */
function test_user($user_url)
{
	$user = new User($user_url);

	echo "--------------------------- Test User --------------------------------";

	// 获取用户ID
	$user_id = $user->get_user_id();
	var_dump($user_id);
	
	// 获取用户关注数
	$followees_num = $user->get_followees_num();
	var_dump($followees_num);
	
	// 获取用户粉丝数
	$followers_num = $user->get_followers_num();
	var_dump($followers_num);
	
	// 获取用户获得的赞同数
	$agree_num = $user->get_agree_num();
	var_dump($agree_num);
	
	// 获取用户获得感谢数
	$thanks_num = $user->get_thanks_num();
	var_dump($thanks_num);
	
	// 获取用户问题提问数
	$asks_num = $user->get_asks_num();
	var_dump($asks_num);
	
	// 获取用户问题回答数
	$answer_num = $user->get_answers_num();
	var_dump($answer_num);

	// 获取用户收藏数
	$collection_num = $user->get_collections_num();
	var_dump($collection_num);
	
	// 获取用户关注列表
	$followees = $user->get_followees();
	var_dump($followees);
	
	// 获取用户粉丝列表
	$followers = $user->get_followers();
	var_dump($followers);
	
	// 获取用户提问列表
	$asks = $user->get_asks();
	var_dump($asks);
	
	// 获取用户回答列表
	$answer = $user->get_answers();
	var_dump($answer);
	
	// 获取用户信息
	$about = $user->get_about();
	var_dump($about);
	
	// 获取用户关注话题数
	$topics_num = $user->get_topics_num();
	var_dump($topics_num);
	
	// 获取用户关注话题列表
	$topic_list = $user->get_topics();
	var_dump($topic_list);
	
	// 获取用户头像URL
	$avatar = $user->get_avatar();
	var_dump($avatar);
}


/**
 * Test Question
 */
function test_question($question_url)
{
	$question = new Question($question_url);

	echo "--------------------------- Test Question --------------------------------";

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

	// 获取排名第三的回答
	$answer = $question->get_answers(3, false);
	var_dump($answer);

	// 获取排名前三的回答
	$answer_list = $question->get_answers(3);
	var_dump($answer_list);

	// 获取问题被浏览数
	$times = $question->get_visit_times();
	var_dump($times);

	// 获取关注该问题的用户
	$followers_list = $question->get_followers(30);
	var_dump($followers_list);

}


function test_answer($answer_url)
{
	$answer = new Answer($answer_url);
	
	echo "--------------------------- Test Answer --------------------------------";

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
}

function test_topics($topics_url)
{
	$topics = new Topic($topics_url);

	// 获取话题描述
	$description = $topics->get_description();
	var_dump($description);

	// 获取话题关注人数
	$followers_num = $topics->get_followers();
	var_dump($followers_num);

	// 获取父话题
	$parent = $topics->get_parent();
	var_dump($parent);

	// 获取子话题
	$children = $topics->get_children();
	var_dump($children);

	// 获取最佳回答者
	$answerer = $topics->get_answerer();
	var_dump($answerer);
}

function test_collection($collection_url)
{
	$collection = new Collection($collection_url);

	// 获取收藏夹名称
	$title = $collection->get_title();
	var_dump($title);

	// 获取收藏夹简介
	$description = $collection->get_description();
	var_dump($description);

	// 获取收藏夹建立者
	$author = $collection->get_author();
	var_dump($author);

}

$user_url = 'https://www.zhihu.com/people/ahonn';

$question_url = 'https://www.zhihu.com/question/38813693';

$answer_url = 'https://www.zhihu.com/question/19550393/answer/12202130';

$topics_url = 'https://www.zhihu.com/topic/19552330';

$collection_url = 'https://www.zhihu.com/collection/19650606';

// test_user($user_url);
// test_question($question_url);
// test_answer($answer_url);
// test_topics($topics_url);
test_collection($collection_url);