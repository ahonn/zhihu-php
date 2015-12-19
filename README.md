# zhihu-php 知乎数据解析

## 介绍
zhihu-php 使用PHP编写，用于获取知乎上的各种信息。看了由 Python2.7 编写的 [zhihu-python](https://github.com/egrcc/zhihu-python) 与 Python3 编写的 [zhihu-py3](https://github.com/7sDream/zhihu-py3) 之后就想着用 PHP 也写一个，重复造造轮子。

**本项目需要 `PHP version >= 5.3` ，开启 `CURL` 扩展**

## 快速开始
### 克隆本项目
	git clone https://github.com/ahonn/zhihu-php

### User：获取用户信息

**创建 User 对象**
``` php
	require_once 'zhihu.php';

	$user_url = 'https://www.zhihu.com/people/ahonn';
	$user = new User($user_url);
``` 

**获取该用户的信息**
``` php

	// 获取用户ID
	$user_id = $user->get_user_id();
	
	// 获取用户关注数
	$followees_num = $user->get_followees_num();

	// 获取用户粉丝数
	$followers_num = $user->get_followers_num();

	// 获取用户获得的赞同数
	$agree_num = $user->get_agree_num();

	// 获取用户获得感谢数
	$thanks_num = $user->get_thanks_num();

	// 获取用户问题提问数
	$asks_num = $user->get_asks_num();

	// 获取用户问题回答数
	$answer_num = $user->get_answers_num();

	// 获取用户收藏数
	$collection_num = $user->get_collections_num();

	// 获取用户关注列表
	$followees = $user->get_followees();

	// 获取用户粉丝列表
	$followers = $user->get_followers();

	// 获取用户提问列表
	$asks = $user->get_asks();

	// 获取用户回答列表
	$answer = $user->get_answers();
```

### Question：获取问题信息
**创建 Question 对象**
``` php
	require_once 'zhihu.php';

	$question_url = 'https://www.zhihu.com/question/19550396';
	$question = new Question($user_url);
```

**获取该问题的信息**
``` php

	// 获取问题标题
	$title = $question->get_title();

	// 获取问题描述，返回字符串
	$detail_str = $question->get_detail_str();

	// 获取问题描述，返回HTML
	$detail_html = $question->get_detail_html();

	// 获取问题回答数
	$answers_num = $question->get_answers_num();

	// 获取问题关注数
	$followers_num = $question->get_followers_num();

	// 获取问题话题列表
	$topic_list = $question->get_topics();

	// 获取排名第三的回答
	$answer = $question->get_answers(3, false);

	// 获取排名前三的回答
	$answer_list = $question->get_answers(3);

	// 获取问题被浏览数
	$times = $question->get_visit_times();

```

### Answer：获取答案信息
**创建 Answer 对象**
``` php
	require_once 'zhihu.php';

	$answer_url = 'https://www.zhihu.com/question/19550393/answer/12202130';
	$answer = new Answer($answer_url);
```

**获取该答案的信息**
``` php

	// 获取回答的问题
	$question = $answer->get_question();
	
	// 获取答主
	$author = $answer->get_author();
	
	// 获取赞同数
	$upvote = $answer->get_upvote();
	
	// 获取回答内容
	$content = $answer->get_content();
	
	// 获取所属问题浏览数
	$visit_times = $answer->get_visit_times();

```

