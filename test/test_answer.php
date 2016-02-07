<?php

require_once '../zhihu/zhihu.php';

class AnswerTest extends PHPUnit_Framework_TestCase
{
	private $url;
	private $answer;
	
	function __construct()
	{
		$this->url = 'https://www.zhihu.com/question/24825703/answer/30975949';
		$this->answer = new Answer($this->url);
	}

	public function testQuestion()
	{
		$question = $this->answer->question();

		$this->assertInstanceOf('Question', $question);
	}

	public function testAuthor()
	{
		$author = $this->answer->author();

		$this->assertInstanceOf('User', $author);
	}

	public function testContent()
	{
		$content = $this->answer->content();

		$this->assertNotEmpty($content);
	}

	public function testUpvote()
	{
		$upvote = $this->answer->upvote();
		$this->assertInternalType('int', $upvote);

		$voters = $this->answer->voters();
		$count = 0;
		foreach ($voters as $voter) {
			$count++;
		}
		$this->assertLessThanOrEqual($upvote, $count);
	}

	public function testComment()
	{
		$comments_num = $this->answer->comments_num();
		$this->assertInternalType('int', $comments_num);

		$comments = $this->answer->comments();
		$count = 0;
		foreach ($comments as $comment) {
			$count++;
		}
		$this->assertGreaterThanOrEqual($comments_num, $count);
	}

	public function testCollection()
	{
		$collections_num = $this->answer->collections_num();
		$this->assertInternalType('int', $collections_num);

		$collections = $this->answer->collections();
		$count = 0;
		foreach ($collections as $collection) {
			$count++;
		}
		$this->assertLessThanOrEqual($collections_num, $count);	
	}
}
