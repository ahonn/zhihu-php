<?php
require_once 'lib/time.php';
require_once 'lib/simple_html_dom.php';
require_once 'lib/request.php';
require_once 'zhihu/user.php';
require_once 'zhihu/question.php';
require_once 'zhihu/answer.php';
require_once 'zhihu/topic.php';
require_once 'zhihu/collection.php';
require_once 'zhihu/comment.php';

// Cookie
define('COOKIE', '');

// URL
define('ZHIHU_URL', 'https://www.zhihu.com');

define('USER_PREFIX_URL', 'https://www.zhihu.com/people/');
define('QUESTION_PREFIX_URL', 'https://www.zhihu.com/question/');
define('TOPICS_PREFIX_URL', 'https://www.zhihu.com/topic/');
define('COLLECTION_PREFIX_URL', 'https://www.zhihu.com/collection/');

define('FOLLOWEES_SUFFIX_URL', '/followees');
define('FOLLOWERS_SUFFIX_URL', '/followers');
define('ASKS_PAGE_SUFFIX_URL', '/asks?page=');
define('ANSWERS_SUFFIX_URL', '/answer');
define('ANSWERS_PAGE_SUFFIX_URL', '/answers?page=');
define('TOPICS_SUFFIX_URL', '/topics');
define('TOPICS_HOT_SUFFIX_URL', '/hot');
define('TOPICS_TOP_SUFFIX_URL', '/top-answers');
define('TOPICS_NEW_SUFFIX_URL', '/questions');
define('GET_PAGE_SUFFIX_URL', '?page=');

define('FOLLOWEES_LIST_URL', 'https://www.zhihu.com/node/ProfileFolloweesListV2');
define('FOLLOWERS_LIST_URL', 'https://www.zhihu.com/node/ProfileFollowersListV2');
define('ANSWERS_LIST_URL', 'http://www.zhihu.com/node/QuestionAnswerListV2');
define('COMMENT_LIST_URL', 'https://www.zhihu.com/node/AnswerCommentBoxV2');

set_time_limit(0);



