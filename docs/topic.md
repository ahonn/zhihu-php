Topic 类
========
根据 URL 生成话题对象
``` php
// 设置话题链接
$topic_url = 'https://www.zhihu.com/topic/19606711';

// 实例化 Topic 对象
$topic = new Topic($topic_url);
```

获取话题基本信息
----------------
获取该话题的名称，描述，关注人数，相关话题以及最佳回答者

``` php
// 获取话题名称
$name = $topic->get_name();
var_dump($name);

// 输出：string '程序员' (length=9)

// 获取话题描述
$description = $topic->get_description();
var_dump($description);

// 输出：string '程序员可以指在程序设计某个专业领域中的专业人士或是从事软件撰写，程序开发、维护的专业人员。' (length=135)

// 获取话题关注人数
$followers_num = $topic->get_followers();
var_dump($followers_num);

// 输出：int 104375

// 获取父话题
$parent = $topic->get_parent();
var_dump($parent);

/**
 * 输出该话题的父话题，返回数组 
 * ****************************
 * array (size=1)
 *   0 => 
 *     object(Topic)[3106]
 *       public 'url' => string 'https://www.zhihu.com/topic/19594551' (length=36)
 *       private 'name' => string ' IT 人 ' (length=8)
 */

// 获取子话题
$children = $topic->get_children();
var_dump($children);

/**
 * 输出该话题的子话题，返回数组
 * 
 * array (size=25)
 *   0 => 
 *     object(Topic)[3871]
 *       public 'url' => string 'https://www.zhihu.com/topic/19557488' (length=36)
 *       private 'name' => string '架构师' (length=11)
 *   1 => 
 *     object(Topic)[3872]
 *       public 'url' => string 'https://www.zhihu.com/topic/19629329' (length=36)
 *       private 'name' => string 'Java 程序员' (length=16)
 *   2 => 
 *     object(Topic)[3873]
 *       public 'url' => string 'https://www.zhihu.com/topic/19596531' (length=36)
 *       private 'name' => string '反射（编程语言）' (length=26)
 *   3 => 
 *     object(Topic)[3874]
 *       public 'url' => string 'https://www.zhihu.com/topic/19573936' (length=36)
 *       private 'name' => string '前端工程师' (length=17)
 *   4 => 
 *     object(Topic)[3875]
 *       public 'url' => string 'https://www.zhihu.com/topic/19799199' (length=36)
 *       private 'name' => string '码农提问' (length=14)
 * .....
 */

// 获取最佳回答者
$answerer = $topic->get_answerer();
var_dump($answerer);

/**
 * 输出该话题下的最佳回答者
 * ************************
 * array (size=5)
 *   0 => 
 *     object(User)[3896]
 *       public 'url' => string 'https://www.zhihu.com/people/yao-dong-27' (length=40)
 *       private 'name' => string '姚冬' (length=6)
 *   1 => 
 *     object(User)[3897]
 *       public 'url' => string 'https://www.zhihu.com/people/rednaxelafx' (length=40)
 *       private 'name' => string 'RednaxelaFX' (length=11)
 * .....
 */
```

获取话题下的最热，精华，全部问题
--------------------------------
``` php
// 获取话题下的热门问题
$hot_question = $topic->get_hot_question();
foreach ($hot_question as $question) {
	var_dump($question);
}
	
/**
 * 输出话题下的热门问题
 * ********************
 * object(Question)[6242]
 *   public 'url' => string 'https://www.zhihu.com/question/38982069' (length=39)
 *   private 'title' => string '夫妻双码农，税前年薪北京60W+ CNY，如去硅谷23W+ USD，小孩不到3岁，请问值得去吗？谢谢！' (length=119)
 * object(Question)[6243]
 *   public 'url' => string 'https://www.zhihu.com/question/39208186' (length=39)
 *   private 'title' => string '2016年前端学习计划？' (length=28)
 * object(Question)[6242]
 *   public 'url' => string 'https://www.zhihu.com/question/39169653' (length=39)
 *   private 'title' => string '大一新生对编程很有兴趣但买不起电脑，该如何正确处理编程与电脑的关系？' (length=102)
 * ......
 */

// 获取该话题下的最新问题
$new_question = $topic->get_new_question();
foreach ($new_question as $question) {
	var_dump($question);
}

// 获取该话题下全部问题
$all_question = $topic->get_all_question();
foreach ($all_question as $question) {
	var_dump($question);
}

// 获取该话题下精华回答
$top_answer = $topic->get_top_answer();
foreach ($top_answer as $answer) {
	var_dump($answer);
}

/**
 * 获取该话题下精华回答
 * ********************
 * object(Answer)[3887]
//   public 'url' => string 'https://www.zhihu.com/question/29357990/answer/44260471' (length=55)
 *   private 'question' => 
 *     object(Question)[3885]
 *       public 'url' => string 'https://www.zhihu.com/question/29357990' (length=39)
 *       private 'title' => string '如何看待 36 岁清华毕业 IT 男马桶上猝死，死前对母亲说「太累」？' (length=89)
 *   private 'author' => 
 *     object(User)[3886]
 *       public 'url' => string 'https://www.zhihu.com/people/baiyunjie' (length=38)
 *       private 'name' => string '白云杰' (length=9)
 *   private 'upvote' => string '39K ' (length=4)
 *   private 'content' => string ' 谨以这文字，给我的老友，给我们的友谊。&lt;br&gt;&lt;br&gt;死者张斌是我最好的朋友，我们从小学一年级开始一个学校，一直经过初中，高中和大学，毕业后，我在北京，他在南方。&lt;br&gt;&lt;br&gt;他是个善良而内向的人，永远在微笑，母亲和姐姐都是教师，他从小学习就很好，我记得最深的，是大学考英语，前面的听力他一定睡着，不是装酷，是因为我们那个年纪的河南考生，听力都'... (length=5247)
 * object(Answer)[3890]
 *   public 'url' => string 'https://www.zhihu.com/question/32422838/answer/55775344' (length=55)
 *   private 'question' => 
 *     object(Question)[3888]
 *       public 'url' => string 'https://www.zhihu.com/question/32422838' (length=39)
 *       private 'title' => string '怎么写出一本程序员风格的修真小说？' (length=51)
 *   private 'author' => 
 *     object(User)[3889]
 *       public 'url' => string 'https://www.zhihu.com/people/li-zhao-hong-14' (length=44)
 *       private 'name' => string '李昭鸿' (length=9)
 *   private 'upvote' => string '22K ' (length=4)
 *   private 'content' => string ' &lt;p&gt;更新了一下，稍微完善了一点。&lt;/p&gt;&lt;br&gt;&lt;p&gt;大体没改。&lt;/p&gt;&lt;br&gt;&lt;p&gt;很多人问结衣是新垣结衣还是波多老师，这个问题很深刻。&lt;/p&gt;&lt;br&gt;&lt;p&gt;答案是，你心里是什么，她就是什么。&lt;/p&gt;&lt;br&gt;&lt;p&gt;么么你们个哒。&lt;/p&gt;&lt;p&gt;*************************************************************************************************************&lt;/p&gt;&lt;p&gt;终有一天我手中的编译'... (length=28668)
 * .......
 */
```