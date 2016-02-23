<?php


require_once '../zhihu/zhihu.php';

class QuestionTest extends PHPUnit_Framework_TestCase
{
	private $url;
	private $question;
	
	function __construct()
	{
		$this->url = 'https://www.zhihu.com/question/27187478';
		$this->question = new Question($this->url);
	}

	public function testTitle()
	{
		$title = $this->question->title();
		$title_tmp = '徒手码一千行以上代码是一种怎样的体验？';
		printf("%s \n", $title);

		$this->assertSame($title_tmp, $title);
	}

	public function testDetail()
	{
		$detail = $this->question->detail();
		$detail_tmp = '在学C语言（非本专业），感觉看着代码一行一行码下来好爽啊。不知道徒手码一千行以上的代码是个什么感觉呢？有人试过吗？';
		printf("%s \n", $detail);

		$this->assertSame($detail_tmp, $detail);
	}

	public function testAnswer()
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

	public function testFollower()
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

	public function testTopic()
	{
		$topics = $this->question->topics();
		$topics_tmp = array("编程", "编程学习");
		$this->assertSame($topics_tmp, $topics);
	}	
}