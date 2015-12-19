<?php

require_once 'lib/simple_html_dom.php';
require_once 'lib/request.php';
require_once 'zhihu/user.php';
require_once 'zhihu/question.php';
require_once 'zhihu/answer.php';

// Cookie
define('COOKIE', "_za=49121d34-f954-4c03-8312-70f297be0719; _xsrf=58f669c38860b22821aea272667b6ffb; q_c1=2fbe4135ed0c424c988683146db619de|1448352668000|1448352668000; cap_id=MjkzNTE5OTQxMzdhNDBiNjg5MmMyMzI3MjM3ZjY4OTc=|1450168234|ab23cb949c6a6cdc28a4a1e761f5755113a89cf5; __utma=51854390.853340688.1448352673.1450157361.1450168244.4; __utmz=51854390.1448352673.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1; __utmb=51854390.6.10.1450168244; __utmc=51854390; __utmt=1; z_c0=QUFCQW4zZ3pBQUFYQUFBQVlRSlZUYzFjbDFid2ZvLWR3YThIOVk0WGxEanpTM1NlX0s0eHF3PT0=|1450168269|a83f56bbd949c807be2d70daf9700cfe60fb5079; unlock_ticket=QUFCQW4zZ3pBQUFYQUFBQVlRSlZUZFhXYjFZVFdiQ3JfdXhyMWtZTjZTSWF6Sl9tcmpfdlpBPT0=|1450168269|7d4db11aa94e5f109075f9c02bfd95fffd0b58d9");

// URL
define('ZHIHU_URL', 'https://www.zhihu.com');

define('USER_PREFIX_URL', 'https://www.zhihu.com/people/');
define('QUESTION_PREFIX_URL', 'https://www.zhihu.com/question/');

define('ASKS_SUFFIX_URL', '/asks?page=');
define('ANSWERS_SUFFIX_URL', '/answers?page=');

define('FOLLOWEES_LIST_URL', 'https://www.zhihu.com/node/ProfileFolloweesListV2');
define('FOLLOWERS_LIST_URL', 'https://www.zhihu.com/node/ProfileFollowersListV2');
define('ANSWERS_LIST_URL', 'http://www.zhihu.com/node/QuestionAnswerListV2');





