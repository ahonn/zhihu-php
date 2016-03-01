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
		printf("%s \n", $question->title());

		$this->assertInstanceOf('Question', $question);
	}

	public function testAuthor()
	{
		$author = $this->answer->author();
		printf("%s \n", $author->name());

		$this->assertInstanceOf('User', $author);
	}

	public function testContent()
	{
		$content = $this->answer->content();
		printf("%s \n", $content);

		$this->assertNotEmpty($content);
	}

	public function testUpvote()
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

	public function testCollection()
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
}
