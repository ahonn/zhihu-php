# zhihu-php 知乎数据解析 by PHP

## 介绍
zhihu-php 使用PHP编写，用于获取知乎上的各种信息。看了由 Python2.7 编写的 [zhihu-python](https://github.com/egrcc/zhihu-python) 想着自己用 PHP 写一个，于是有了这个项目。

**本项目需要 `PHP version >= 5.3` ，开启 `CURL` 扩展**

根据 URL 生成对应的对象，例如知乎用户对象 User、知乎问题对象 Question、答案对象 Answer 等等。

## 准备
打开 `zhi.php`，将知乎的 Cookie 复制黏贴到 `COOKIE` 的常量定义中：
``` php
define('COOKIE', "");
```

## 简单样例
``` php
<?php
require_one 'zhihu-php/zhihu.php';

$question_url = 'https://www.zhihu.com/question/38813693';
$question = new Question($question_url);

// 获取该问题前五的回答
$answer_list = $question->get_answer(5);
foreach ($answer_list as $answer) {
	echo $answer->get_content;	
}

// 获取该问题排名第五的回答
$answer = $question->get_answer(5, false);
echo $answer;

```

## 文档
- [User 获取用户信息](https://github.com/ahonn/zhihu-php/tree/master/doc/zhihu-user-help.md)
- [Question 获取问题信息](#)
- [Answer 获取答案信息](#)
- [Topic 获取话题信息](#)