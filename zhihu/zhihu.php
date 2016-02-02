<?php

set_time_limit(0);

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
const COOKIE = 'q_c1=89866b7ad2944da9a29c831ba64156c7|1453079039000|1453079039000; _za=51ea7776-0cd3-401e-8ca5-418ed33ef1a8; cap_id="NThhMWQxODE3OGJlNGU1YmJkMTFkZjhmOThiNzE5NjQ=|1453111253|9cff5d1bb2bf5cbdd3493f28d33c31d2d9c500b7"; z_c0="QUFCQW4zZ3pBQUFYQUFBQVlRSlZUZkJFeEZZNFdkR3hmcTNld1Qtdng5YTFXdmpPS1RNZ2FBPT0=|1453111280|d3e03cc2b844914f8f3f591980b7b2be3c966c22"; _xsrf=dd3634d2d2afbe464bee2976205fe7da; __utmt=1; __utma=51854390.1313658305.1453079040.1453226793.1453270639.6; __utmb=51854390.2.10.1453270639; __utmc=51854390; __utmz=51854390.1453112913.3.2.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1';

// URL 
const ZHIHU_URL = 'https://www.zhihu.com';
const USER_PREFIX_URL = 'https://www.zhihu.com/people/';
const ANSWERS_PREFIX_URL = 'https://www.zhihu.com/answer/';
const QUESTION_PREFIX_URL = 'https://www.zhihu.com/question/';
const TOPICS_PREFIX_URL = 'https://www.zhihu.com/topic/';
const COLLECTION_PREFIX_URL = 'https://www.zhihu.com/collection/';
const ROUNDTABLE_URL = 'https://www.zhihu.com/roundtable';
const COLLECTION_SUFFIX_URL = '/collections';
const FOLLOWEES_SUFFIX_URL = '/followees';
const FOLLOWERS_SUFFIX_URL = '/followers';
const ASKS_PAGE_SUFFIX_URL = '/asks?page=';
const ANSWERS_SUFFIX_URL = '/answer';
const ANSWERS_PAGE_SUFFIX_URL = '/answers?page=';
const TOPICS_SUFFIX_URL = '/topics';
const TOPICS_HOT_SUFFIX_URL = '/hot';
const TOPICS_NEW_SUFFIX_URL = '/newest';
const TOPICS_TOP_SUFFIX_URL = '/top-answers';
const TOPICS_ALL_SUFFIX_URL = '/questions';
const GET_PAGE_SUFFIX_URL = '?page=';
const VOTERS_SUFFIX_URL = '/voters_profile';
const FOLLOWEES_LIST_URL = 'https://www.zhihu.com/node/ProfileFolloweesListV2';
const FOLLOWERS_LIST_URL = 'https://www.zhihu.com/node/ProfileFollowersListV2';
const ANSWERS_LIST_URL = 'http://www.zhihu.com/node/QuestionAnswerListV2';
const COMMENT_LIST_URL = 'https://www.zhihu.com/r/answers/{id}/comments';
const COLLECTION_LIST_URL = 'https://www.zhihu.com/node/AnswerFavlists';


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