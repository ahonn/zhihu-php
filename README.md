# zhihu-php

## 介绍
zhihu-php 使用PHP编写，用于获取知乎上的各种信息。

**本项目需要 `PHP version >= 5.3` ，开启 `CURL` 扩展，使用 `simple html dom` 解析网页**

根据 URL 生成对应的对象，例如知乎用户对象 User、知乎问题对象 Question、答案对象 Answer 等等。

## 准备
打开 `zhihu.php`，将知乎的 Cookie 复制黏贴到 `COOKIE` 的常量定义中：
``` php
const COOKIE = "your cookie";
```

## 简单样例
``` php
<?php
require_one 'zhihu/zhihu.php';

// 设置 URL
$question_url = 'https://www.zhihu.com/question/19550393';

// 实例化对象
$question = new Question($question_url);

// 获取该问题排名第一的答案
$answer = $question->top_answer();

// 获取该回答的答主
$author = $answer->author();

// 获取答案答主的信息
$about = $author->about();

// 输出答主基本信息
var_dump($about);
```

## 更新信息
[Change Log](https://github.com/ahonn/zhihu-php/blob/master/ChangeLog.md)

## 联系我
- Email：[ahonn95@outlook.com](mailto:ahonn95@outlook.com)

