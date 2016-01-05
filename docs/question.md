Question 对象
=============

根据 URL 生成知乎问题对象。
``` php
// 设置问题 URL
$question_url = 'https://www.zhihu.com/question/38813693';

// 实例化 Question 对象
$question = new Question($question_url);
```

获取问题基本信息
----------------
获取问题标题，问题描述，问题标签，被浏览数

```	php
// 获取问题标题
$title = $question->get_title();
var_dump($title);

// 输出：string '如何高效自学编程？' (length=27)

// 获取问题描述
$detail_str = $question->get_detail();
var_dump($detail_str);

/**
 * 输出问题描述
 * **************
 *string '  年龄：27，想开始学编程（兴趣爱好，不要笑我），没有任何的基础知识，打算入手基本书籍或网站去自学，然后入手一部笔记本（预算几千），请各位大神指点。

 * 1、先学什么比较好？目的是可以自己编写程序（一个小游戏、网站、app什么的）
 * 2、有什么书籍或者网站可以推荐的？
 * 3、英文是不是队伍编程学习很重要？目前4级水平左右，不过工作多年未接触估计退步了，可以学习'... (length=737)
 */

// 获取问题话题标签
$topics = $question->get_topics();
var_dump($topics);

/**
 * 输出话题标签
 * ************* 
 * array (size=3)
 *   0 => string ' 编程 ' (length=8)
 *   1 => string ' 计算机 ' (length=11)
 *   2 => string ' 程序 ' (length=8)
 */

// 获取问题被浏览数
$times = $question->get_visit_times();
var_dump($times);

// 输出：int 1193
```

获取问题关注相关
----------------
获取该问题被关注数，及关注该问题的用户列表

``` php
// 获取问题关注数
$followers_num = $question->get_followers_num();
var_dump($followers_num);

// 输出：int 1193

// 获取关注该问题的用户
$followers_list = $question->get_followers();
foreach ($followers_list as $followers) {
	var_dump($followers);
}

/**
 * 输出关注该问题的用户
 * ********************
 * object(User)[4999]
 *   private 'url' => string 'https://www.zhihu.com/people/qiejiang' (length=37)
 *   private 'name' => string '茄酱' (length=6)
 * object(User)[5000]
 *   private 'url' => string 'https://www.zhihu.com/people/you-yu-de-xing-xing' (length=48)
 *   private 'name' => string '忧郁的星星' (length=15)
 * object(User)[4999]
 *   private 'url' => string 'https://www.zhihu.com/people/liu-ye-kuan-2' (length=42)
 *   private 'name' => string '宗越' (length=6)
 * ......
 */
```

获取问题回答相关
----------------
获取该问题被回答数，及该问题下回答

``` php
// 获取问题回答数
$answers_num = $question->get_answers_num();
var_dump($answers_num);

// 输出：int 24

// 获取问题的所有回答
$answers = $question->get_answers();
foreach ($answers as $answer) {
	var_dump($answer);
}

/**
 * 输出该问题下的所有答案，返回迭代器 
 * **********************************
 * object(Answer)[3737]
 *   private 'answer_url' => string 'https://www.zhihu.com/question/38813693/answer/78222103' (length=55)
 *   private 'question' => 
 *     object(Question)[2]
 *       private 'question_url' => string 'https://www.zhihu.com/question/38813693' (length=39)
 *       private 'question_title' => null
 *       public 'dom' => 
 *         object(simple_html_dom)[3]
 *		 ...
 *   private 'author' => 
 *     object(User)[3736]
 *       private 'url' => string 'https://www.zhihu.com/people/excited-vczh' (length=41)
 *       private 'name' => string 'vczh' (length=4)
 *   private 'upvote' => string '161 ' (length=4)
 *   private 'content' => string ' 1、熟读并接受《Teach Yourself Programming in 10 Years》
 * 2、不断写代码，不要干别的事情。
 * 很快就学会编程了。  ' (length=145)
 * ......
 */

// 获取该问题排名Top n的答案，可选参数为答案排名，默认为最高票答案
$answer = $question->get_top_answer(5);
var_dump($answer);

/**
 * 输出该问题下排名第5的回答
 * *************************
 * object(Answer)[3737]
 *   private 'answer_url' => string 'https://www.zhihu.com/question/38813693/answer/78327104' (length=55)
 *   private 'question' => 
 *     object(Question)[2]
 *       private 'question_url' => string 'https://www.zhihu.com/question/38813693' (length=39)
 *       private 'question_title' => null
 *       public 'dom' => 
 *         object(simple_html_dom)[3]
 *           public 'root' => 
 *             object(simple_html_dom_node)[4]
 *               ...
 *   private 'author' => 
 *     object(User)[3736]
 *       private 'url' => string 'https://www.zhihu.com/people/ctkjer' (length=35)
 *       private 'name' => string '蔡广颂' (length=9)
 *   private 'upvote' => string '0 ' (length=2)
 *   private 'content' => string ' 先学好英语，可以后来居上。  ' (length=42)
 */
```