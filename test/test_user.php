<?php

require_once '../zhihu/zhihu.php';

class UserTest extends PHPUnit_Framework_TestCase
{
	public $url;
	public $user;

	function __construct() 
	{
		$this->url = 'https://www.zhihu.com/people/ahonn';
		$this->user = new User($this->url);
	}

	public function testAbout()
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

	public function testFollowee()
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

	public function testFollower()
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

	public function testAgree()
	{
		$agree_num = $this->user->agree_num();
		$this->assertInternalType('int', $agree_num);
		printf("%d \n", $agree_num);
	}

	public function testThanks()
	{
		$thanks_num = $this->user->thanks_num();
		$this->assertInternalType('int', $thanks_num);
		printf("%d \n", $thanks_num);
	}

	public function testAsks()
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

	public function testAnswers()
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

	public function testColumn()
	{
		$columns = $this->user->columns();
		foreach ($columns as $column) {
			$this->assertInstanceOf('Column', $column);
			printf("%s \n", $column->name());
		}
	}

	public function testPosts()
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

	public function testCollection()
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

	public function testTopic()
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
}