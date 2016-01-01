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
const COOKIE = '';

/**
 * 首页 URL
 */
const ZHIHU_URL = 'https://www.zhihu.com';

/**
 * 用户 URL 前缀
 */
const USER_PREFIX_URL = 'https://www.zhihu.com/people/';

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
 * 话题精华 URL 后缀
 */
const TOPICS_TOP_SUFFIX_URL = '/top-answers';

/**
 * 话题最新 URL 后缀
 */
const TOPICS_NEW_SUFFIX_URL = '/questions';

/**
 * 页码 URL 后缀
 */
const GET_PAGE_SUFFIX_URL = '?page=';

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
