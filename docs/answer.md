Answer 类
===========

根据 URl 生成问题对象。
``` php
// 设置问题的 URL
$answer_url = 'https://www.zhihu.com/question/38199129/answer/79525121';

// 实例化 Answer 对象
$answer = new Answer($answer_url);
```

获取答案内容
----------------
**获取该回答的问题及答主**

``` php
// 获取回答的问题
$question = $answer->get_question();
var_dump($question);
	
/**
 * 输出回答的问题，返回 Question 对象
 * **********************************
 * object(Question)[1177]
 *   public 'url' => string 'https://www.zhihu.com/question/38199129' (length=39)
 *   private 'title' => string '为什么程序代码被编译成机器码就不能跨平台运行？' (length=69)
 */

// 获取答主
$author = $answer->get_author();
var_dump($author);

/**
 * 输出该回答的答主，返回 User 对象
 * ********************************
 * object(User)[1178]
 *   public 'url' => string 'https://www.zhihu.com/people/s.invalid' (length=38)
 *   private 'name' => string 'invalid s' (length=9)
 */
```

**获取该回答的点赞数，回答内容，及浏览数**

``` php
// 获取赞同数
$upvote = $answer->get_upvote();
var_dump($upvote);

// 输出：int 815
	
// 获取回答内容
$content = $answer->get_content();
var_dump($content);

/**
 * 输出回答内容
 * ************
 * string ' 来个简单粗暴版。
 * 假设你去西班牙旅游，肚子饿了；但你不会当地语言——就好像程序员想让CPU做什么，但他并不会二进制指令一样。
 * 于是，你掏钱请来一名懂汉语的翻译，告诉他，你想要一份开封菜（KFC）；他自然会把你的话翻译成西班牙语，帮你完成点餐大业——这名翻译官，我们就叫他“编译器”。
 * 你很聪明，不打算下次继续掏钱给翻译。所以你用手机把翻译点餐�'... (length=2555)
 */

// 获取所属问题浏览数
$visit_times = $answer->get_visit_times();
var_dump($visit_times);

// 输出：int 2282
```

**获取答案下的评论**
``` php
// 获取该答案下的评论
$comment_list = $answer->get_comment();
foreach ($comment_list as $comment) {
	var_dump($comment);
}

/**
 * 输出该答案下的评论，返回 Comment 对象，包括评论者，被回复者，
 * 评论内容以及评论时间。可通过 Comment 类的方法获取单个信息
 * *********************************************************************************
 * object(Comment)[3555]
 *   private 'author' => 
 *     object(User)[3554]
 *       public 'url' => string 'https://www.zhihu.com/people/liu-chun-yang-87-98' (length=48)
 *       private 'name' => string '刘春阳' (length=9)
 *   private 'replyed' => null
 *   private 'content' => string ' 666 ' (length=5)
 *   private 'time' => string '2016-01-01 ' (length=11)
 *
 * object(Comment)[3557]
 *   private 'author' => 
 *     object(User)[3556]
 *       public 'url' => string 'https://www.zhihu.com/people/su-xiao-feng-98' (length=44)
 *       private 'name' => string '苏小枫' (length=9)
 *   private 'replyed' => null
 *   private 'content' => string ' 易懂点赞！ ' (length=17)
 *   private 'time' => string '2016-01-01 ' (length=11)
 */
```

**获取该答案被收藏数以及收藏该答案的文件夹**

``` php
// 获取答案收藏数
$collection_num = $answer->get_collection_num();
var_dump($collection_num);

// 输出：int 278

// 获取收藏该回答的收藏夹列表
$collections = $answer->get_collection();
foreach ($collections as $collection) {
	var_dump($collection);
}

/**
 * 输出收藏了该回答的收藏夹
 * ************************ 
 * object(Collection)[2343]
 *   public 'url' => string 'https://www.zhihu.com/collection/20615676' (length=41)
 *   private 'title' => string '不需要解释' (length=15)
 *   private 'author' => 
 *     object(User)[2342]
 *       public 'url' => string 'https://www.zhihu.com/people/watcher' (length=36)
 *       private 'name' => string 'Watcher' (length=7)
 * object(Collection)[2345]
 *   public 'url' => string 'https://www.zhihu.com/collection/34218394' (length=41)
 *   private 'title' => string '实用资料和一些比较有趣的东西（欢迎投稿）' (length=60)
 *   private 'author' => 
 *     object(User)[2344]
 *       public 'url' => string 'https://www.zhihu.com/people/yang-huai-bin' (length=42)
 *       private 'name' => string '杨怀斌' (length=9)
 */
```

**获取点赞该回答的用户**
``` php
// 获取点赞该回答的用户
$voters = $answer->get_voters();
foreach ($voters as $key => $voter) {
	var_dump($voter);
}

/**
 * 输出点赞的用户
 * **************
 * object(User)[1226]
 *   public 'url' => string 'https://www.zhihu.com/people/sheldonelee' (length=40)
 *   private 'name' => string '李焕朋' (length=9)
 * object(User)[1273]
 *   public 'url' => string 'https://www.zhihu.com/people/huxpro' (length=35)
 *   private 'name' => string '黄玄' (length=6)
 */

```