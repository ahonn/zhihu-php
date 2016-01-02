User 对象
=========

根据 URL 生成知乎用户对象。
``` php
// 设置用户的 URL
$user_url = 'https://www.zhihu.com/people/excited-vczh';

// 实例化 User 对象
$user = new User($user_url);
```

获取用户基本信息
----------------
获取用户ID，头像URL，性别，所在地等等。

使用 get_about() 获取所有基本信息，亦可使用 get_{要获取的键名}() 来获取单一信息。
``` php
// 获取用户信息
$about = $user->get_about();

// 输出用户信息
var_dump($about);

/**
 * 输出样例
 * ****************
 * array (size=10)
 *   'user_id' => string 'vczh ' (length=5)
 *   'avatar' => string 'https://pic1.zhimg.com/3a6c25ac3864540e80cdef9bc2a73900.jpg' (length=59)
 *   'location' => string '西雅图（Seattle）' (length=22)
 *   'business' => string '计算机软件' (length=15)
 *   'gender' => string 'male' (length=4)
 *   'employment' => string 'Microsoft Office' (length=16)
 *   'position' => string 'Developer' (length=9)
 *   'education' => string '华南理工大学' (length=18)
 *   'major' => string '软件学院' (length=12)
 *   'description' => string '长期开发跨三大PC平台的GUI库 <a href="//link.zhihu.com/?target=http%3A//www.gaclib.net" class="external" target="_blank" rel="nofollow noreferrer"><span class="invisible">http://www.</span><span class="visible">gaclib.net</span><span class="invisible"></span><i class="icon-external"></i></a>，讨论QQ群：231200072（不闲聊） 不再更新的技术博客：<a href="//link.zhihu.com/?target=http%3A//www.cppblog.com/vczh" class="external" target="_blank" rel="nofollow noreferrer"><span class="i'... (length=649)
 */


// 获取用户 ID
$user_id = $user->get_user_id();
var_dump($user_id);

/**
 * 输出样例
 * **************
 * string 'vczh ' (length=5)
 */
```

获取用户其他信息
----------------
获取该用户关注的用户，关注该用户的用户，该用户关注的话题，等等

**获取用户关注、粉丝**
``` php
// 所关注的用户数
$followees_num = $user->get_followees_num();
var_dump($followees_num);

// 输出：int 1493

// 所关注的用户列表，返回迭代器
$followees_list = $user->get_followees();
foreach ($followees_list as $followees) {
	var_dump($followees);
}

/**
 * 输出该用户所关注的用户列表
 * **************************
 * object(User)[4230]
 *   private 'user_url' => string 'https://www.zhihu.com/people/Kirio' (length=34)
 *   private 'user_id' => string 'Kirio' (length=5)
 * object(User)[4231]
 *   private 'user_url' => string 'https://www.zhihu.com/people/mao-yu-ai-li-si-55' (length=47)
 *   private 'user_id' => string '猫与爱丽丝' (length=15)
 * ....
 */


// 关注该用户的粉丝数
$followers_num = $user->get_followers_num();
var_dump(followers_num);

// 输出：int 232270

// 获取该用户粉丝列表，返回迭代器
$followers_list = $user->get_followers();
foreach ($followers_list as $followers) {
	var_dump($followers);
}
```


**获取该用户被赞同，感谢数，专栏文章数**
``` php
// 获取用户获得的赞同数
$agree_num = $user->get_agree_num();
var_dump($agree_num);

// 输出：int 484778

// 获取用户获得感谢数
$thanks_num = $user->get_thanks_num();
var_dump($thanks_num);

// 输出：int 63607

// 获取用户专栏文章数
$posts_num = $user->get_posts();
var_dump($posts_num);

// 输出：int 32
```


**获取用户提问，回答**
``` php
// 获取用户问题提问数
$asks_num = $user->get_asks_num();
var_dump($asks_num);

// 输出：int 310

// 获取用户提问列表，返回迭代器
$asks_list = $user->get_asks();
foreach ($asks_list as $asks) {
	var_dump($asks);
}

/**
 * 输出用户提问列表
 * ***********************
 * object(Question)[4150]
 *   private 'question_url' => string 'https://www.zhihu.com/question/39081089' (length=39)
 *   private 'question_title' => string '如何评价Google Contributor？' (length=33)
 * object(Question)[4151]
 *   private 'question_url' => string 'https://www.zhihu.com/question/39080584' (length=39)
 *   private 'question_title' => string '如果一个宗教的教义在多处地方都跟本国法律相抵触，那正确对待他的方法是什么，应该承认这个宗教吗？' (length=141)
 * .....
 */

// 获取用户问题回答数
$answer_num = $user->get_answers_num();
var_dump($answer_num);

// 输出：int 9847

// 获取用户提问列表
$asks_list = $user->get_asks();
foreach ($asks_list as $asks) {
	var_dump($asks);
}
```


**获取用户关注的话题**
``` php
// 获取用户关注话题数
$topics_num = $user->get_topics_num();
var_dump($topics_num);
	
// 输出：int 12

// 获取用户关注话题列表
$topic_list = $user->get_topics();
foreach ($topic_list as $topic) {
	var_dump($topic);
}

/**
 * 输出用户关注话题列表
 * ********************
 * object(Topic)[6670]
 *   private 'topics_url' => string 'https://www.zhihu.com/topic/19554298' (length=36)
 *   private 'topics_id' => string '编程' (length=6)
 * object(Topic)[6671]
 *   private 'topics_url' => string 'https://www.zhihu.com/topic/19551667' (length=36)
 *   private 'topics_id' => string '微软（Microsoft）' (length=21)
 * object(Topic)[6670]
 *   private 'topics_url' => string 'https://www.zhihu.com/topic/19550517' (length=36)
 *   private 'topics_id' => string '互联网' (length=9)
 */
```
