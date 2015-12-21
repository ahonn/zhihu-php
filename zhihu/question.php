<?php

class Question 
{
	private $question_url;
	private $title;
	private $dom;

	function __construct($question_url, $title=null)
	{
		if (substr($question_url, 0, 31) !== QUESTION_PREFIX_URL) {
			throw new Exception($question_url.": it isn't a question url !");
		} else {
			$this->question_url = $question_url;
			if ( ! empty($title)) {
				$this->title = $title;
			}
		}	
	}


	/**
	 * 解析user_url为simple html dom对象
	 * @return [Object] [simple html dom 对象]
	 */
	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->question_url);

			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 获取问题标题
	 * @return [string] [标题]
	 */
	public function get_title()
	{
		if ( ! empty($this->title)) {
			return $this->title;
		} else {
			$this->parser();
			$title = $this->dom->find('h2.zm-item-title', 0)->plaintext;
			$this->title = $title;
			return $title;
		}
	}

	/**
	 * 获取问题描述
	 * @return [string] [问题描述]
	 */
	public function get_detail_str()
	{
		$this->parser();
		$detail = $this->dom->find('div#zh-question-detail', 0)->plaintext;
		return $detail;
	}

	/**
	 * 获取问题描述
	 * @return [html] [问题描述]
	 */
	public function get_detail_html()
	{
		$this->parser();
		$detail = $this->dom->find('div#zh-question-detail [class!=zu-edit-button]', 0)->innertext;
		return $detail;
	}

	/**
	 * 获取问题回答数
	 * @return [int] [回答数]
	 */
	public function get_answers_num()
	{
		$this->parser();
		$answers_num = (int)@$this->dom->find('h3#zh-question-answer-num', 0)->attr['data-num'];

		if (empty($answers_num)) {
			$answers_num = 0;
		}
		return $answers_num;
	}

	/**
	 * 获取问题关注数
	 * @return [int] [关注数]
	 */
	public function get_followers_num()
	{
		$this->parser();
		$followers_num = (int)$this->dom->find('div.zg-gray-normal strong', 0)->plaintext;
		return $followers_num;
	}

	/**
	 * 获取话题分类
	 * @return [array] [话题分类]
	 */
	public function get_topics()
	{
		$this->parser();
		for ($i = 0; @$this->dom->find('a.zm-item-tag',$i) != null ; $i++) { 
			$topic_list[] = $this->dom->find('a.zm-item-tag',$i)->plaintext;
		}
		return $topic_list;
	}

	/**
	 * 获取回答
	 * @param  [int]  $top  [答案排行]
	 * @param  [boolean] $list [是否返回答案集]
	 * @return [string/array]        [答案/答案集]
	 */
	public function get_answers($top=null, $list=true)
	{
		$this->get_title();
		$answers_num = empty($top)? $this->get_answers_num(): $top; 

		if ($answers_num == 0) {
			return null;
		} else {
			$post_url = ANSWERS_LIST_URL;
			$_xsrf = $this->dom->find('input[name=_xsrf]', 0)->value;
		  	$json = $this->dom->find('div#zh-question-answer-wrap', 0)->attr['data-init'];

			for ($i = 0; $i < $answers_num / 50; $i++) { 
				if($i == 0) {
					for ($j = 0; $j < min($answers_num, 50); $j++) { 
						$answer_url = $this->dom->find('a.answer-date-link', $j)->href;

						$author_link = $this->dom->find('div.zm-item-answer-author-info', $j);
						if (@!empty($author_link->find('a.author-link', 0))) {
							$author_id = $author_link->find('a.author-link', 0)->plaintext;
							$author_url = ZHIHU_URL.$author_link->find('a.author-link', 0)->href;
						} else {
							$author_id = $author_link->find('span', 0)->plaintext;
							$author_url = null;
						}
						$author = new User($author_url, $author_id);

						$upvote_link = $this->dom->find('button.up', $j);
						if (@!empty($upvote_link->find('span.count', 0))) {
							$upvote = $upvote_link->find('span.count', 0)->plaintext;
						} else {
							$upvote = $this->dom->find('div.zm-item-vote')->plaintext;
						}

						$content = $this->dom->find('div.zm-item-answer', $j)->find('div.zm-editable-content', 0)->plaintext;
						$answer[] = new Answer($answer_url, $this, $author, $upvote, $content);
					}
				} else {
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 50;
					$params = json_encode($params);

					$data = array(
						'_xsrf' => $_xsrf,
						'method' => 'next',
						'params' => $params
					);

					$r = Request::post($post_url, $data, array("Referer: {$this->question_url}" ));

					$r = json_decode($r)->msg;

					for ($j = 0; $j < min($answers_num - $i * 50, 50); $j++) { 
						$dom = str_get_html($r[$j]);

						$answer_url = $dom->find('a.answer-date-link', 0)->href;

						$author_link = $dom->find('div.zm-item-answer-author-info', 0);
						if (@!empty($author_link->find('a.author-link', 0))) {
							$author_id = $author_link->find('a.author-link', 0)->plaintext;
							$author_url = ZHIHU_URL.$author_link->find('a.author-link', 0)->href;
						} else {
							$author_id = $author_link->find('span', 0)->plaintext;
							$author_url = null;
						}
						$author = new User($author_url, $author_id);

						$upvote_link = $dom->find('button.up', 0);
						if (@!empty($upvote_link->find('span.count', 0))) {
							$upvote = $upvote_link->find('span.count', 0)->plaintext;
						} else {
							$upvote = $dom->find('div.zm-item-vote')->plaintext;
						}

						$content = $dom->find('div.zm-item-answer', 0)->find('div.zm-editable-content', 0)->plaintext;
						$answer[] = new Answer($answer_url, $this, $author, $upvote, $content);
						
					}
				}
			}
			return $list? $answer: $answer[$top-1];
		}
	}

	/**
	 * 获取问题浏览数
	 * @return [int] [浏览数]
	 */
	public function get_visit_times()
	{
		$this->parser();
		$times = (int)$this->dom->find('div.zg-gray-normal strong', 0)->plaintext;
		return $times;
	}
}