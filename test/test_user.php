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
	}

	public function testFollowee()
	{
		$followees_num = $this->user->followees_num();
		$this->assertInternalType('int', $followees_num);
		
		$followees = $this->user->followees();
		$count = 0;
		foreach ($followees as $followee) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($followees_num, $count);
	}

	public function testFollower()
	{
		$followers_num = $this->user->followers_num();
		$this->assertInternalType('int', $followers_num);
		
		$followers = $this->user->followers();
		$count = 0;
		foreach ($followers as $follower) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($followers_num, $count);
	}

	public function testAgree()
	{
		$agree_num = $this->user->agree_num();
		$this->assertInternalType('int', $agree_num);
	}

	public function testThanks()
	{
		$thanks_num = $this->user->thanks_num();
		$this->assertInternalType('int', $thanks_num);
	}

	public function testAsks()
	{
		$asks_num = $this->user->asks_num();
		$this->assertInternalType('int', $asks_num);

		$asks = $this->user->asks();
		$count = 0;
		foreach ($asks as $ask) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($asks_num, $count);
	}

	public function testAnswers()
	{
		$answers_num = $this->user->answers_num();
		$this->assertInternalType('int', $answers_num);

		$answers = $this->user->answers();
		$count = 0;
		foreach ($answers as $answer) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($answers_num, $count);
	}

	public function testPosts()
	{
		$posts_num = $this->user->posts_num();
		$this->assertInternalType('int', $posts_num);
	}

	public function testCollection()
	{
		$collections_num = $this->user->collections_num();
		$this->assertInternalType('int', $collections_num);
	}

	public function testTopic()
	{
		$topics_num = $this->user->topics_num();
		$this->assertNotEmpty($topics_num);
	
		$topics = $this->user->topics();
		$count = 0;
		foreach ($topics as $topic) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($topics_num, $count);
	}
}