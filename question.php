<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-15 20:19:28
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-16 21:01:02
 */

require_once 'lib/simple_html_dom.php';
require_once 'request.php';

class Question
{
	private $question_url;
	private $title;
	private $dom;

	function __construct($question_url, $title=null)
	{
		if (substr($question_url, 0, 31) !== "https://www.zhihu.com/question/") {
			throw new Exception($question_url.": it isn't a question url !");
		} 
		else {
			$this->question_url = $question_url;
			if ( ! empty($title)) {
				$this->title = $title;
			}
		}	
	}

	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->question_url);

			$this->dom = str_get_html($r);
		}
	}

	public function get_title()
	{
		if ( ! empty($this->title)) {
			return $this->title;
		}
		else {
			$this->parser();
			$title = $this->dom->find('h2.zm-item-title', 0)->plaintext;
			$this->title = $title;
			return $title;
		}
	}

	public function get_detail_str()
	{
		$this->parser();
		$detail = $this->dom->find('div#zh-question-detail', 0)->plaintext;
		return $detail;
	}

	public function get_detail_html()
	{
		$this->parser();
		$detail = $this->dom->find('div#zh-question-detail [class!=zu-edit-button]', 0)->innertext;
		return $detail;
	}


	public function get_answers_num()
	{
		$this->parser();
		$answers_num = @$this->dom->find('h3#zh-question-answer-num', 0)->attr['data-num'];

		if (empty($answers_num)) {
			$answers_num = '0';
		}
		return $answers_num;
	}


	public function get_followers_num()
	{
		$this->parser();
		$followers_num = $this->dom->find('div.zg-gray-normal strong', 0)->plaintext;
		return $followers_num;
	}


	public function get_topics()
	{
		$this->parser();
		for ($i = 0; @$this->dom->find('a.zm-item-tag',$i) != null ; $i++) { 
			$topic_list[] = $this->dom->find('a.zm-item-tag',$i)->plaintext;
		}
		return $topic_list;
	}

	public function get_answers()
	{
		$answers_num = $this->get_answers_num();
		if ($answers_num == 0) {
			return null;
		}
		else {
			for ($i = 0; $i < $answers_num / 50; $i++) { 
				if($i == 0) {
					for ($j = 0; $j < min($answers_num, 50); $j++) { 
						$answer_url = $this->dom->find('a.answer-date-link', $j)->href;
						
						$author_link = $this->dom->find('div.zm-item-answer-author-info', $j);
						if (@!empty($author_link->find('a.author-link', 0))) {
							$author_id = $author_link->find('a.author-link', 0)->plaintext;
							$author_url = 'https://www.zhihu.com'.$author_link->find('a.author-link', 0)->href;
						}
						else {
							$author_id = $author_link->find('span', 0)->plaintext;
							$author_url = null;
						}
						$author = new User($author_url, $author_id);
						var_dump($author);

						$upvote_link = $this->dom->find('button.up', $j);
						if (@!empty($upvote_link->find('span.count', 0))) {
							$upvote = $upvote_link->find('span.count', 0)->plaintext;
						}
						else {
							$upvote = $this->dom->find('div.zm-item-vote')->plaintext;
						}


					}
				}
			}
		}
	}
}