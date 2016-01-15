<?php

set_time_limit(0);

require_once dirname(__FILE__) .'/zhihu/libraries/simple_html_dom.php';
require_once dirname(__FILE__) .'/zhihu/libraries/request.php';

function __autoload($class)
{
	if (file_exists(dirname(__FILE__) . '/zhihu/' . $class . '.php')) {
		require_once(dirname(__FILE__) . '/zhihu/' . $class . '.php');
	}
}

/**
 * 设置 cookie 
 */
const COOKIE = 'q_c1=0bececc01938485b9f53fb861f1e3a09|1451374262000|1451374262000; _za=774754b5-1e6f-4c5b-be79-08a65c9e198c; _xsrf=cfa92cdf2061545910d43e57d1634b94; _ga=GA1.2.280749046.1452361232; cap_id="MTU2NjQ0MDVmM2U5NGY3OGJkOTc3Mzk2YzE5MmJmMDg=|1452741625|d1e8ae8d861d6811473fd29d9e8558c6364d7b2e"; z_c0="QUFCQW4zZ3pBQUFYQUFBQVlRSlZUV1NpdmxhYVRadE5rblNramFyazdlZW1UZ21zN052eXhRPT0=|1452741988|843c71f102706b525c3b314e813250af53270efa"; __utmt=1; __utma=51854390.1751597568.1452778482.1452788128.1452788128.3; __utmb=51854390.7.8.1452828812227; __utmc=51854390; __utmz=51854390.1452788128.2.2.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1';

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

function parser_about_item($item, $edit_str)
{
	if ( ! empty($item)) {
		$about_item = trim($item->plaintext);
		if ($about_item == $edit_str) {
			$about_item = null;
		}
	} else {
		$about_item = null;
	}
	return $about_item;
}

function parser_topics_from_user($topic)
{
	$topic_url = ZHIHU_URL.$topic->find('a', 1)->href;
	$topic_name = $topic->find('a', 1)->plaintext;
	return new Topic($topic_url, $topic_name);
}

function parser_question_from_user($question)
{
	$question_url = ZHIHU_URL.substr($question->href, 0, 18);
	$question_title = $question->plaintext;
	return new Question($question_url, $question_title);
}