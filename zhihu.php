<?php

set_time_limit(0);

require_once dirname(__FILE__) .'/zhihu/simple_html_dom/simple_html_dom.php';

function __autoload($class)
{
	if (file_exists(dirname(__FILE__) . '/zhihu/' . $class . '.php')) {
		require_once(dirname(__FILE__) . '/zhihu/' . $class . '.php');
	}
}

/**
 * 设置 cookie 
 */
const COOKIE = 'q_c1=0bececc01938485b9f53fb861f1e3a09|1451374262000|1451374262000; cap_id="Yjk3OGYzMGYyZmY1NDZiZjlmN2MwNzg2ZGQxNWU1ZTY=|1451374262|26a62e5db0643bf3f527942341264fbf05f0c1af"; _za=774754b5-1e6f-4c5b-be79-08a65c9e198c; z_c0="QUFCQW4zZ3pBQUFYQUFBQVlRSlZUY0REcVZaaHhlR0t2N3NrR244VzYyZmU5cm5uQnBSUktRPT0=|1451374272|1f48597f0d2cacac441b94235bd20cbf1b6bdfd9"; _xsrf=cfa92cdf2061545910d43e57d1634b94; __utma=51854390.1679535047.1451626147.1451626147.1451629103.2; __utmb=51854390.13.8.1451629299882; __utmc=51854390; __utmz=51854390.1451626147.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1';

/**
 * 首页 URL
 */
const ZHIHU_URL = 'https://www.zhihu.com';

/**
 * 用户 URL 前缀
 */
const USER_PREFIX_URL = 'https://www.zhihu.com/people/';

/**
 * 答案 URL 前缀
 */
const ANSWERS_PREFIX_URL = 'https://www.zhihu.com/answer/';

/**
 * 问题 URL 前缀
 */
const QUESTION_PREFIX_URL = 'https://www.zhihu.com/question/';

/**
 * 话题 URL 前缀
 */
const TOPICS_PREFIX_URL = 'https://www.zhihu.com/topic/';

/**
 * 收藏夹 URL 前缀
 */
const COLLECTION_PREFIX_URL = 'https://www.zhihu.com/collection/';

/**
 * 收藏夹 URL 后缀
 */
const COLLECTION_SUFFIX_URL = '/collections';

/**
 * 用户关注 URL 后缀
 */
const FOLLOWEES_SUFFIX_URL = '/followees';

/**
 * 用户粉丝 URL 后缀
 */
const FOLLOWERS_SUFFIX_URL = '/followers';

/**
 * 用户提问 URL 后缀
 */
const ASKS_PAGE_SUFFIX_URL = '/asks?page=';

/**
 * 用户回答 URL 后缀
 */
const ANSWERS_SUFFIX_URL = '/answer';
const ANSWERS_PAGE_SUFFIX_URL = '/answers?page=';

/**
 * 话题 URL 后缀
 */
const TOPICS_SUFFIX_URL = '/topics';

/**
 * 话题热门 URL 后缀
 */
const TOPICS_HOT_SUFFIX_URL = '/hot';

/**
 * 话题最新 URL 后缀
 */
const TOPICS_NEW_SUFFIX_URL = '/newest';

/**
 * 话题精华 URL 后缀
 */
const TOPICS_TOP_SUFFIX_URL = '/top-answers';

/**
 * 话题全部问题 URL 后缀
 */
const TOPICS_ALL_SUFFIX_URL = '/questions';

/**
 * 页码 URL 后缀
 */
const GET_PAGE_SUFFIX_URL = '?page=';

/**
 * 答案赞同 URL 后缀 
 */
const VOTERS_SUFFIX_URL = '/voters_profile';

/**
 * 用户关注 POST URL
 */
const FOLLOWEES_LIST_URL = 'https://www.zhihu.com/node/ProfileFolloweesListV2';

/**
 * 用户粉丝 POST URL
 */
const FOLLOWERS_LIST_URL = 'https://www.zhihu.com/node/ProfileFollowersListV2';

/**
 * 用户回答 POST URL
 */
const ANSWERS_LIST_URL = 'http://www.zhihu.com/node/QuestionAnswerListV2';

/**
 * 答案评论 POST URL
 */
const COMMENT_LIST_URL = 'https://www.zhihu.com/node/AnswerCommentBoxV2';

/**
 * 答案收藏夹 POST URL
 */
const COLLECTION_LIST_URL = 'https://www.zhihu.com/node/AnswerFavlists';

