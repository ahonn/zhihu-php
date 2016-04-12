<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

require_once dirname(__FILE__) .'/libraries/simple_html_dom.php';
require_once dirname(__FILE__) .'/libraries/request.php';

function __autoload($class)
{
	if (file_exists(dirname(__FILE__) . '/' . strtolower($class) . '.php')) {
		require_once(dirname(__FILE__) . '/' . strtolower($class). '.php');
	}
}

/**
 * 设置 cookie
 */
const COOKIE = '_za=a8e7629f-b2c6-426f-a5ad-9e12822913e5; q_c1=778677133ad646b4a15874f17588605f|1457398772000|1454754491000; _xsrf=75d946e46e97c3565083f1a07a95719c; udid="ADAAMMoClQmPTjF3naszhl1kYbadV5ksAyY=|1457503694"; cap_id="YmJlODc1MWZjNmE1NDY3N2IwMGZmNGM4YTczNGZkNDQ=|1457957051|099a8b54d6242c5024b936eb671408aad756edb9"; z_c0="QUFCQW4zZ3pBQUFYQUFBQVlRSlZUWDQzRGxkd0VXRHNzSGVDekIxRnlhMFZ5bmJvZFVSWjNBPT0=|1457957502|4ee2089395328c4e828e3e3bac0f8b3a88848d64"; d_c0="ACBAlDEzoQmPTg2il_whqWd_3T-11OLaw4o=|1458216769"; __utmt=1; __utma=51854390.1408474369.1458209063.1458279737.1458294617.8; __utmb=51854390.11.8.1458294655920; __utmc=51854390; __utmz=51854390.1458270890.5.2.utmcsr=zhihu.com|utmccn=(referral)|utmcmd=referral|utmcct=/; __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1';

// URL
const ZHIHU_URL = 'https://www.zhihu.com';
const USER_PREFIX_URL = 'https://www.zhihu.com/people/';
const ANSWERS_PREFIX_URL = 'https://www.zhihu.com/answer/';
const QUESTION_PREFIX_URL = 'https://www.zhihu.com/question/';
const TOPICS_PREFIX_URL = 'https://www.zhihu.com/topic/';
const COLLECTION_PREFIX_URL = 'https://www.zhihu.com/collection/';
const ROUNDTABLE_PREFIX_URL = 'https://www.zhihu.com/roundtable/';
const COLUMN_PREFIX_URL = 'http://zhuanlan.zhihu.com';

const FOLLOWEES_LIST_URL = 'https://www.zhihu.com/node/ProfileFolloweesListV2';
const FOLLOWERS_LIST_URL = 'https://www.zhihu.com/node/ProfileFollowersListV2';
const ANSWERS_LIST_URL = 'http://www.zhihu.com/node/QuestionAnswerListV2';
const COMMENT_LIST_URL = 'https://www.zhihu.com/r/answers/{id}/comments';
const COLLECTION_LIST_URL = 'https://www.zhihu.com/node/AnswerFavlists';
const COLUMN_POSTS_URL = 'http://zhuanlan.zhihu.com/api/columns/{id}';
const POST_URL = 'http://zhuanlan.zhihu.com/api/columns/{uid}/posts/{pid}';

const COLLECTION_SUFFIX_URL = '/collections';
const FOLLOWEES_SUFFIX_URL = '/followees';
const FOLLOWERS_SUFFIX_URL = '/followers';
const ANSWERS_SUFFIX_URL = '/answer';
const ASKS_PAGE_SUFFIX_URL = '/asks?page=';
const ANSWERS_PAGE_SUFFIX_URL = '/answers?page=';

const TOPICS_SUFFIX_URL = '/topics';
const TOPICS_HOT_SUFFIX_URL = '/hot';
const TOPICS_NEW_SUFFIX_URL = '/newest';
const TOPICS_TOP_SUFFIX_URL = '/top-answers';
const TOPICS_ALL_SUFFIX_URL = '/questions';

const VOTERS_SUFFIX_URL = '/voters_profile';
const GET_PAGE_SUFFIX_URL = '?page=';


function _xsrf($dom)
{
	return $dom->find('input[name=_xsrf]', 0)->value;
}

function parser_user($dom)
{
	if ( ! empty($dom = $dom->find("a", 0))) {
		$user_url = $dom->href;
		if(strpos($user_url, ZHIHU_URL) === false) {
			$user_url = ZHIHU_URL.$user_url;
		}
		$user_name = trim($dom->plaintext);
	} else {
		$user_url = null;
		$user_name = null;
	}
	return new User($user_url, $user_name);
}

function parser_question($dom)
{
	$question_url = ZHIHU_URL.substr($dom->href, 0, 18);
	$question_title = trim($dom->plaintext);
	return new Question($question_url, $question_title);
}

function parser_topic($dom)
{
	$topic_url = ZHIHU_URL.substr($dom->href, 0, 15);
	$topic_name = trim($dom->plaintext);
	return new Topic($topic_url, $topic_name);
}

function parser_topics_from_user($dom)
{
	$topic_url = ZHIHU_URL.$dom->find('a', 1)->href;
	$topic_name = $dom->find('a', 1)->plaintext;
	return new Topic($topic_url, $topic_name);
}

function parser_answer_from_question($question, $dom, $n = 0)
{
	$answer_url = ZHIHU_URL.$dom->find('a.answer-date-link', $n)->href;

	$author_link = $dom->find('div.zm-item-answer-author-info', $n);
	if ( ! empty($author_link->find('a.author-link', 0))) {
		$author_name = $author_link->find('a.author-link', 0)->plaintext;
		$author_url = ZHIHU_URL.$author_link->find('a.author-link', 0)->href;
	} else {
		$author_name = $author_link->find('span', 0)->plaintext;
		$author_url = null;
	}
	$author = new User($author_url, $author_name);

	$upvote_link = $dom->find('button.up', $n);
	if (! empty($upvote_link->find('span.count', 0))) {
		$upvote = $upvote_link->find('span.count', 0)->plaintext;
	} else {
		$upvote = $dom->find('div.zm-item-vote')->plaintext;
	}

	$content = trim($dom->find('div.zm-item-answer', $n)->find('div.zm-editable-content', 0)->plaintext);
	return new Answer($answer_url, $question, $author, $upvote, $content);
}

function parser_collection_from_answer($dom)
{
	$collection_link = $dom->find('h2 a', 0);
	$collection_url = ZHIHU_URL.$collection_link->href;
	$collection_title = $collection_link->plaintext;

	if ( ! empty($author_link = $dom->find('div a[class!=zg-unfollow]', 0))) {
		$author_url = $author_link->href;
		$author_id = $author_link->plaintext;

		$collection_author = new User($author_url, $author_id);
	} else {
		$collection_author = null;
	}

	return new Collection($collection_url, $collection_title, $collection_author);
}

function parser_user_from_topic($dom)
{
	if (empty($dom->href)) {
		$user_url = null;
		$user_name = null;
	} else {
		$user_url = ZHIHU_URL.$dom->href;
		$user_name = trim($dom->plaintext);
	}
	return new User($user_url, $user_name);
}
