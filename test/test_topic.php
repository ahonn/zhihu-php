<?php

require_once '../zhihu/zhihu.php';

class TopicTest extends PHPUnit_Framework_TestCase
{

	function __construct()
	{
		$this->url = 'https://www.zhihu.com/topic/19552330';
		$this->topic = new Topic($this->url);
	}

	public function testName()
	{
		$name = $this->topic->name();
        printf("%s \n", $name);
		$name_tmp = '程序员';

		$this->assertSame($name_tmp, $name);
	}

	public function testDesc()
	{
		$desc = $this->topic->desc();
        printf("%s \n", $desc);
		$desc_tmp = '程序员可以指在程序设计某个专业领域中的专业人士或是从事软件撰写，程序开发、维护的专业人员。';

		$this->assertSame($desc_tmp, $desc);
	}

	public function testFollower()
	{
		$followers_num = $this->topic->followers_num();
        printf("%d \n", $followers_num);
		$this->assertInternalType('int', $followers_num);
	}

	public function testParentAndChildren()
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

	public function testAnswerer()
	{
		$answerer = $this->topic->answerer();
		foreach ($answerer as $user) {
            printf("%s \n", $user->name());
			$this->assertInstanceOf('User', $user);
		}
	}

	public function testQuestion()
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

	public function testAnswer()
	{
		$top_answer = $this->topic->top_answer();
		for($i = 0; $i < 200; $i++) {
			$answer = $top_answer->current();
            printf("%s \n", $answer->question()->title());
            $top_answer->next();
			$this->assertInstanceOf('Answer', $answer);
		}
	}
}
