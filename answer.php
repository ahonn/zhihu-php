<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-15 22:41:53
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-16 20:15:20
 */
require_once 'lib/simple_html_dom.php';
require_once 'request.php';

class Answer
{
	private $answer_url;
	private $question;
	private $author;
	private $upvote;
	private $content;

	function __construct($answer_url, $question=null, $author=null, $upvote=null, $content=null)
	{
		$this->answer_url = $answer_url;
		if ( ! empty($question)) {
			$this->question = $question;
		}
		if ( ! empty($author)) {
			$this->author = $author;
		}
		if ( ! empty($upvote)) {
			$this->upvote = $upvote;
		}
		if ( ! empty($content)) {
			$this->content = $content;
		}
	}

	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->answer_url);
			$this->dom = str_get_html($r);
		}
	}

	public function get_question()
	{
		if( ! empty($this->question)) {
			$question = $this->question;
		}
		else {
			$question_link = $this->dom->find('h2.zm-item-title',0);
			$question_url = $question_link->href();
			$title = $question_link->plaintext;
			$question = Question($question_url, $title);
		}
		return $question;
	}

	public function get_author()
	{
		if ( ! empty($this->author)) {
			$author = $this->author();
		}
		else {
			$this->parser();
			# TODO
		}
	}
}