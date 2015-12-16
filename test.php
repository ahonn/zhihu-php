<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-14 19:41:32
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-16 20:57:40
 */
require_once 'request.php';
require_once 'user.php';
require_once 'question.php';
require_once 'answer.php';

/**
 * 	Test User 
 */

$user_url = "https://www.zhihu.com/people/ahonn";
$user = new User($user_url);

// $user_id = $user->get_user_id();
// var_dump($user_id);

// $followees_num = $user->get_followees_num();
// var_dump($followees_num);

// $followers_num = $user->get_followers_num();
// var_dump($followers_num);

// $agree_num = $user->get_agree_num();
// var_dump($agree_num);

// $thanks_num = $user->get_thanks_num();
// var_dump($thanks_num);

// $asks_num = $user->get_asks_num();
// var_dump($asks_num);

// $answer_num = $user->get_answers_num();
// var_dump($answer_num);

// $collection_num = $user->get_collections_num();
// var_dump($collection_num);

// $followees = $user->get_followees();
// var_dump($followees);

// $followers = $user->get_followers();
// var_dump($followers);

// $asks = $user->get_asks();
// var_dump($asks);

// $answer = $user->get_answers();
// var_dump($answer);

// var_dump($user);

///////////////////////////////////////////////////

$question_url = 'https://www.zhihu.com/question/30993476';
$question = new Question($question_url);

// $title = $question->get_title();
// var_dump($title);

// $detail_str = $question->get_detail_str();
// var_dump($detail_str);

// $detail_html = $question->get_detail_html();
// print_r($detail_html);

// $answers_num = $question->get_answers_num();
// var_dump($answers_num);


// $followers_num = $question->get_followers_num();
// var_dump($followers_num);

// $topic_list = $question->get_topics();
// var_dump($topic_list);

$answer_list = $question->get_answers();
// var_dump($answer_list);