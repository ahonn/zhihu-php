<?php

require_once '../zhihu/zhihu.php';

class CommentTest extends PHPUnit_Framework_TestCase
{
	private $url;
	private $comments;

	function __construct()
	{
		$this->url = 'https://www.zhihu.com/question/19550393/answer/12202130';
		$answer = new Answer($this->url);
		$this->comments = $answer->comments();
	}

	public function testAuthor()
	{
		foreach ($this->comments as $comment) {
			$author = $comment->author();
			$this->assertInstanceOf('User', $author);
		}
	}

	public function testContent()
	{
		foreach ($this->comments as $comment) {
			$content = $comment->content();
			$this->assertInternalType('string', $content);
		}
	}

	public function testReplyed()
	{
		foreach ($this->comments as $comment) {
			$replyed = $comment->replyed();
			try {
				$this->assertInstanceOf('User', $replyed);
			} catch (Exception $e) {
				$this->assertEquals(NULL, $replyed);
			}
		}
	}
}

