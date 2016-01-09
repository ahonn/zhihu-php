Collection 类
=============

根据 URL 生成收藏夹对象
``` php
// 设置收藏夹 URL
$collection_url = 'https://www.zhihu.com/collection/19650606';

// 实例化 Collection 对象
$collection = new Collection($collection_url);
```

获取收藏夹信息
--------------
``` php
// 获取收藏夹名称
$title = $collection->get_title();
var_dump($title);

// 输出：string '妙趣横生' (length=12)

// 获取收藏夹简介
$description = $collection->get_description();
var_dump($description);

// string '嬉笑怒骂，剑走偏锋，思路切入显大巧，文字构筑含义深。' (length=78)

// 获取收藏夹建立者
$author = $collection->get_author();
var_dump($author);

/**
 * 输出收藏夹创建者
 * ****************
 * object(User)[4306]
 *   public 'url' => string 'https://www.zhihu.com/people/yang-kai-guang' (length=43)
 *   private 'name' => string '杨凯光' (length=9)
 */

// 获取收藏夹内容
$answer_list = $collection->get_answers();
foreach ($answer_list as $answer) {
	var_dump($answer);
}

/**
 * 输出收藏夹内容，返回迭代器
 * **************************
 * object(Answer)[8614]
 *   public 'url' => string 'https://www.zhihu.com/question/39185971/answer/80093711' (length=55)
 *   private 'question' => 
 *     object(Question)[8612]
 *       public 'url' => string 'https://www.zhihu.com/question/39185971' (length=39)
 *       private 'title' => string '狗狗每天晚上特别狂，是不是得了狂犬病了？' (length=60)
 *   private 'author' => 
 *     object(User)[8613]
 *       public 'url' => string 'https://www.zhihu.com/people/bai-ye-3-75' (length=40)
 *       private 'name' => string '白夜' (length=6)
 *   private 'upvote' => string '1258' (length=4)
 *   private 'content' => string ' 想开点，也许只是你屋里有鬼而已。    发布于 2016-01-05    ' (length=77)
 * object(Answer)[8617]
 *   public 'url' => string 'https://www.zhihu.com/question/31162294/answer/80326159' (length=55)
 *   private 'question' => 
 *     object(Question)[8615]
 *       public 'url' => string 'https://www.zhihu.com/question/31162294' (length=39)
 *       private 'title' => string '人生怎样才算是真正精彩？' (length=36)
 *   private 'author' => 
 *     object(User)[8616]
 *       public 'url' => string 'https://www.zhihu.com/people/younglaoshi' (length=40)
 *       private 'name' => string '左岸右水' (length=12)
 *   private 'upvote' => string '2778' (length=4)
 *   private 'content' => string ' 那年我两岁，&lt;br&gt;相貌如花蕊，&lt;br&gt;喜欢玩尿泥，&lt;br&gt;爱扎双马尾，&lt;br&gt;老师夸我乖，&lt;br&gt;爸妈说我匪，&lt;br&gt;有天在喝奶，&lt;br&gt;奶瓶被打碎，&lt;br&gt;割伤大拇指，&lt;br&gt;鲜血喝一嘴，&lt;br&gt;手指缝六针，&lt;br&gt;记号永相随。&lt;br&gt;长到十一岁，&lt;br&gt;差点去轮回，&lt;br&gt;庸医误诊断，&lt;br&gt;说我肺积水，&lt;br&gt;去你奶的腿。&lt;br&gt;后来上中学，&lt;br&gt;还是�'... (length=2029)
 * ........
 */
```