<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-14 19:41:32
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-14 21:50:05
 */
require_once 'user.php';

$user_url = "http://www.zhihu.com/people/ahonn";
$user = new User($user_url);
$user_id = $user->get_user_id();
var_dump($user_id);

$followees_num = $user->get_followees_num();
var_dump($followees_num);

$followers_num = $user->get_followers_num();
var_dump($followers_num);

$agree_num = $user->get_agree_num();
var_dump($agree_num);

$thanks_num = $user->get_thanks_num();
var_dump($thanks_num);

$asks_num = $user->get_asks_num();
var_dump($asks_num);

$answer_num = $user->get_answers_num();
var_dump($answer_num);

$collection_num = $user->get_collections_num();
var_dump($collection_num);


// var_dump($user);