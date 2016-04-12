<?php

require_once '../zhihu/zhihu.php';

class ZhihuTest extends PHPUnit_Framework_TestCase
{
    public $user;
    public $question;
    public $answer;
    public $topic;
    public $collection;
    public $column;
    public $post;

    function __construct()
    {
        $this->user = new User('https://www.zhihu.com/people/ahonn');
        $this->question = new Question('https://www.zhihu.com/question/27187478');
		    $this->answer = new Answer('https://www.zhihu.com/question/24825703/answer/30975949');
		    $this->topic = new Topic('https://www.zhihu.com/topic/19552330');
        $this->collection = new Collection('https://www.zhihu.com/collection/19650606');
    }

    ///////////////// User ///////////////////

    public function testUserAbout()
	{
		$about = $this->user->about();

		$this->assertArrayHasKey('name', $about);
		$this->assertArrayHasKey('avatar', $about);
		$this->assertArrayHasKey('weibo_url', $about);
		$this->assertArrayHasKey('location', $about);
		$this->assertArrayHasKey('business', $about);
		$this->assertArrayHasKey('gender', $about);
		$this->assertArrayHasKey('employment', $about);
		$this->assertArrayHasKey('position', $about);
		$this->assertArrayHasKey('education', $about);
		$this->assertArrayHasKey('major', $about);
		$this->assertArrayHasKey('desc', $about);

		foreach ($about as $info) {
			printf("%s \n", $info);
		}
	}

	public function testUserFollowee()
	{
		$followees_num = $this->user->followees_num();
		$this->assertInternalType('int', $followees_num);
		printf("%d \n", $followees_num);

		$followees = $this->user->followees();
		$count = 0;
		foreach ($followees as $followee) {
			$count++;
			$this->assertInstanceOf('User', $followee);
			printf("%s \n", $followee->name());
		}
		$this->assertGreaterThanOrEqual($followees_num, $count);
	}

	public function testUserFollower()
	{
		$followers_num = $this->user->followers_num();
		$this->assertInternalType('int', $followers_num);
		printf("%d \n", $followers_num);

		$followers = $this->user->followers();
		$count = 0;
		foreach ($followers as $follower) {
			$count++;
			$this->assertInstanceOf('User', $follower);
			printf("%s \n", $follower->name());
		}
		$this->assertGreaterThanOrEqual($followers_num, $count);
	}

	public function testUserAgree()
	{
		$agree_num = $this->user->agree_num();
		$this->assertInternalType('int', $agree_num);
		printf("%d \n", $agree_num);
	}

	public function testUserThanks()
	{
		$thanks_num = $this->user->thanks_num();
		$this->assertInternalType('int', $thanks_num);
		printf("%d \n", $thanks_num);
	}

	public function testUserAsks()
	{
		$asks_num = $this->user->asks_num();
		$this->assertInternalType('int', $asks_num);
		printf("%d \n", $asks_num);

		$asks = $this->user->asks();
		$count = 0;
		foreach ($asks as $ask) {
			$count++;
			$this->assertInstanceOf('Question', $ask);
			printf("%s \n", $ask->title());
		}
		$this->assertGreaterThanOrEqual($asks_num, $count);
	}

	public function testUserAnswers()
	{
		$answers_num = $this->user->answers_num();
		$this->assertInternalType('int', $answers_num);
		printf("%d \n", $answers_num);

		$answers = $this->user->answers();
		$count = 0;
		foreach ($answers as $answer) {
			$count++;
			$this->assertInstanceOf('Answer', $answer);
			printf("%s \n", $answer->question()->title());
		}
		$this->assertGreaterThanOrEqual($answers_num, $count);
	}

	public function testUserColumn()
	{
		$columns = $this->user->columns();
		foreach ($columns as $column) {
			$this->assertInstanceOf('Column', $column);
			printf("%s \n", $column->name());
		}
	}

	public function testUserPosts()
	{
		$posts_num = $this->user->posts_num();
		$this->assertInternalType('int', $posts_num);
		printf("%d \n", $posts_num);

		if($posts_num != 0) {
			$posts = $this->user->posts();
			$count = 0;
			foreach ($posts as $post) {
				$count++;
				$this->assertInstanceOf('Post', $post);
				printf("%s \n", $post->title());
			}
			$this->assertGreaterThanOrEqual($posts_num, $count);
		}
	}

	public function testUserCollection()
	{
		$collections_num = $this->user->collections_num();
		$this->assertInternalType('int', $collections_num);
		printf("%d \n", $collections_num);

		$collections = $this->user->collections();
		$count = 0;
		foreach ($collections as $collection) {
			$count++;
			$this->assertInstanceOf('Collection', $collection);
			printf("%s \n", $collection->title());
		}
		$this->assertGreaterThanOrEqual($collections_num, $count);
	}

	public function testUserTopic()
	{
		$topics_num = $this->user->topics_num();
		$this->assertNotEmpty($topics_num);
		printf("%d \n", $topics_num);

		$topics = $this->user->topics();
		$count = 0;
		foreach ($topics as $topic) {
			$count++;
			$this->assertInstanceOf('Topic', $topic);
			printf("%s \n", $topic->name());
		}
		$this->assertGreaterThanOrEqual($topics_num, $count);
	}

    ///////////////// Question ///////////////////

    public function testQuestionTitle()
	{
		$title = $this->question->title();
		$title_tmp = '徒手码一千行以上代码是一种怎样的体验？';
		printf("%s \n", $title);

		$this->assertSame($title_tmp, $title);
	}

	public function testQuestionDetail()
	{
		$detail = $this->question->detail();
		$detail_tmp = '在学C语言（非本专业），感觉看着代码一行一行码下来好爽啊。不知道徒手码一千行以上的代码是个什么感觉呢？有人试过吗？';
		printf("%s \n", $detail);

		$this->assertSame($detail_tmp, $detail);
	}

	public function testQuestionAnswer()
	{
		$answers_num = $this->question->answers_num();
		$this->assertInternalType('int', $answers_num);
		printf("%d \n", $answers_num);

		$answers = $this->question->answers();
		$count = 0;
		foreach ($answers as $answer) {
			$count++;
			$this->assertInstanceOf('Answer', $answer);
			printf("%s \n", $answer->author()->name());
		}
		$this->assertGreaterThanOrEqual($answers_num, $count);
	}

	public function testQuestionFollower()
	{
		$followers_num = $this->question->followers_num();
		$this->assertInternalType('int', $followers_num);
		printf("%d \n", $followers_num);

		$followers = $this->question->followers();
		$count = 0;
		foreach ($followers as $follower) {
			$count++;
			$this->assertInstanceOf('User', $follower);
			printf("%s \n", $follower->name());
		}
		$this->assertLessThanOrEqual($followers_num, $count);
	}

	public function testQuestionTopic()
	{
		$topics = $this->question->topics();
		$topics_tmp = array("编程", "编程学习");
		$this->assertSame($topics_tmp, $topics);
	}

    ///////////////// Answer ///////////////////

    public function testAnswerQuestion()
	{
		$question = $this->answer->question();
		printf("%s \n", $question->title());

		$this->assertInstanceOf('Question', $question);
	}

	public function testAnswerAuthor()
	{
		$author = $this->answer->author();
		printf("%s \n", $author->name());

		$this->assertInstanceOf('User', $author);
	}

	public function testAnswerContent()
	{
		$content = $this->answer->content();
		printf("%s \n", $content);

		$this->assertNotEmpty($content);
	}

	public function testAnswerUpvote()
	{
		$upvote = $this->answer->upvote();
		$this->assertInternalType('int', $upvote);
		printf("%d \n", $upvote);

		$voters = $this->answer->voters();
		$count = 0;
		foreach ($voters as $voter) {
			$count++;
			$this->assertInstanceOf('User', $voter);
			printf("%s \n", $voter->name());
		}
		$this->assertLessThanOrEqual($upvote, $count);
	}

	public function testAnswerCollection()
	{
		$collections_num = $this->answer->collections_num();
		$this->assertInternalType('int', $collections_num);
		printf("%d \n", $collections_num);

		$collections = $this->answer->collections();
		$count = 0;
		foreach ($collections as $collection) {
			$count++;
			$this->assertInstanceOf('Collection', $collection);
			printf("%s \n", $collection->title());
		}
		$this->assertLessThanOrEqual($collections_num, $count);
	}

    ///////////////// Topic ///////////////////

    public function testTopicName()
	{
		$name = $this->topic->name();
        printf("%s \n", $name);
		$name_tmp = '程序员';

		$this->assertSame($name_tmp, $name);
	}

	public function testTopicDesc()
	{
		$desc = $this->topic->desc();
        printf("%s \n", $desc);
		$desc_tmp = '程序员可以指在程序设计某个专业领域中的专业人士或是从事软件撰写，程序开发、维护的专业人员。';

		$this->assertSame($desc_tmp, $desc);
	}

	public function testTopicFollower()
	{
		$followers_num = $this->topic->followers_num();
        printf("%d \n", $followers_num);
		$this->assertInternalType('int', $followers_num);
	}

	public function testTopicParentAndChildren()
	{
		$parents = $this->topic->parents();
		foreach ($parents as $parent) {
            printf("%s \n", $parent->name());
			$this->assertInstanceOf('Topic', $parent);
		}

		$childrens = $this->topic->childrens();
		foreach ($childrens as $children) {
            printf("%s \n", $children->name());
			$this->assertInstanceOf('Topic', $children);
		}
	}

	public function testTopicAnswerer()
	{
		$answerer = $this->topic->answerer();
		foreach ($answerer as $user) {
            printf("%s \n", $user->name());
			$this->assertInstanceOf('User', $user);
		}
	}

	public function testTopicQuestion()
	{
		$hot_question = $this->topic->hot_question();
		for($i = 0; $i < 200; $i++) {
			$question = $hot_question->current();
            printf("%s \n", $question->title());
            $hot_question->next();
			$this->assertInstanceOf('Question', $question);
		}

		$new_question = $this->topic->new_question();
		for($i = 0; $i < 200; $i++) {
			$question = $new_question->current();
            printf("%s \n", $question->title());
            $new_question->next();
			$this->assertInstanceOf('Question', $question);
		}

		$all_question = $this->topic->all_question();
		for($i = 0; $i < 200; $i++) {
			$question = $all_question->current();
            printf("%s \n", $question->title());
            $all_question->next();
			$this->assertInstanceOf('Question', $question);
		}
	}

	public function testTopicAnswer()
	{
		$top_answer = $this->topic->top_answer();
		for($i = 0; $i < 200; $i++) {
			$answer = $top_answer->current();
            printf("%s \n", $answer->question()->title());
            $top_answer->next();
			$this->assertInstanceOf('Answer', $answer);
		}
	}

    ////////////// Collection /////////////////

    public function testCollectionTitle()
    {
        $title = $this->collection->title();
        $title_tmp = '妙趣横生';
        printf("%s \n", $title);

        $this->assertSame($title_tmp, $title);
    }

    public function testCollectionDesc()
    {
        $desc = $this->collection->desc();
        $desc_tmp = '嬉笑怒骂，剑走偏锋，思路切入显大巧，文字构筑含义深。';
        printf("%s \n", $desc);

        $this->assertSame($desc_tmp, $desc);
    }

    public function testCollectionAuthor()
    {
        $author = $this->collection->author();
        $this->assertInstanceOf('User', $author);

        $author_name = '杨凯光';
        printf("%s \n", $author->name());
        $this->assertSame($author_name, $author->name());
    }


    public function testCollectionAnswer()
    {
        $answers = $this->collection->answers();
        for($i = 0; $i < 200; $i++) {
            $answer = $answers->current();
            $answers->next();
            $this->assertInstanceOf('Answer', $answer);
            printf("%s \n", $answer->question()->title());
        }
    }
}
