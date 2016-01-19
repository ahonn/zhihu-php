<?php

/**
 * 知乎问题类 Question
 */
class Question 
{
	public $url;
	private $title;

	function __construct($url, $title=null)
	{
		if (substr($url, 0, 31) !== QUESTION_PREFIX_URL) {
			throw new Exception($url.": it isn't a question url !");
		} else {
			$this->url = $url;
			if ( ! empty($title)) {
				$this->title = $title;
			}
		}	
	}


	/**
	 * 解析user_url为simple html dom对象
	 * @return object simple html dom 对象
	 */
	public function parser()
	{
		if (empty($this->dom) || ! isset($this->dom)) {
			$r = Request::get($this->url);

			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 获取问题标题
	 * @return string 标题
	 */
	public function title()
	{
		if ( ! empty($this->title)) {
			return $this->title;
		} else {
			$this->parser();
			$title = trim($this->dom->find('h2.zm-item-title', 0)->plaintext);
			$this->title = $title;
			return $title;
		}
	}

	/**
	 * 获取问题描述
	 * @return string 问题描述
	 */
	public function detail()
	{
		$this->parser();
		$detail = $this->dom->find('div#zh-question-detail', 0)->plaintext;
		return $detail;
	}

	/**
	 * 获取问题回答数
	 * @return integer 回答数
	 */
	public function answers_num()
	{
		$this->parser();
		if ( ! empty($this->dom->find('h3#zh-question-answer-num', 0))) {
			$answers_num = (int)$this->dom->find('h3#zh-question-answer-num', 0)->attr['data-num'];
		} else {
			$answers_num = 0;
		}
		return $answers_num;
	}


	/**
	 * 获取问题关注数
	 * @return integer 关注数
	 */
	public function followers_num()
	{
		$this->parser();
		$followers_num = $this->dom->find('div.zg-gray-normal strong', 0)->plaintext;
		return (int)$followers_num;
	}


	/**
	 * 获取话题分类
	 * @return array 话题分类
	 */
	public function topics()
	{
		$this->parser();
		for ($i = 0; @$this->dom->find('a.zm-item-tag',$i) != null ; $i++) { 
			$topic_list[] = $this->dom->find('a.zm-item-tag',$i)->plaintext;
		}
		return $topic_list;
	}


	/**
	 * 获取问题关注者
	 * @return Generator 关注者列表迭代器
	 */
	public function followers()
	{
		$followers_num = $this->followers_num(); 

		if ($followers_num == 0) {
			yield null;
		} else {
			$follwers_url = $this->url.FOLLOWERS_SUFFIX_URL;
			$r = Request::get($follwers_url);
			$dom = str_get_html($r);

			$_xsrf = _xsrf($dom);
			for ($i = 0; $i < $followers_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($followers_num, 20); $j++) { 
						$follower_link = $dom->find('div.zm-profile-card h2 ', $j);
						yield parser_user_from_question($follower_link);
					}
				} else {
					$data = array(
						'start' => 0,
						'offset' => $i * 20,
						'_xsrf' =>$_xsrf
					);

					$r = Request::post($follwers_url, $data, array("Referer: {$follwers_url}"));
					$r = json_decode($r)->msg;
					$dom = str_get_html($r[1]);
					for ($j = 0; $j < min(($followers_num - $i * 20), 20); $j++) {
						$follower_link = $dom->find('div.zm-profile-card h2', $j);
						yield parser_user_from_question($follower_link);
					}
				}
			}
		}
	}


	/**
	 * 获取该问题的回答
	 * @return Generator 答案迭代器
	 */
	public function answers()
	{
		$answers_num = $this->answers_num(); 

		if ($answers_num == 0) {
			yield null;
		} else {
			$post_url = ANSWERS_LIST_URL;
			$_xsrf = $this->dom->find('input[name=_xsrf]', 0)->value;
		  	$json = $this->dom->find('div#zh-question-answer-wrap', 0)->attr['data-init'];

			for ($i = 0; $i < $answers_num / 50; $i++) { 
				if($i == 0) {
					for ($j = 0; $j < min($answers_num, 50); $j++) { 
						yield parser_answer_from_question($this->dom, $n);
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

					$r = Request::post($post_url, $data, array("Referer: {$this->url}" ));
					$r = json_decode($r)->msg;

					for ($j = 0; $j < min($answers_num - $i * 50, 50); $j++) { 
						$dom = str_get_html($r[$j]);
						yield parser_answer_from_question($dom);
					}
				}
			}
		}
	}


	/**
	 * 获取问题排名Top n的回答
	 * @param  integer $top 答案排名
	 * @return object       Answer 对象
	 */
	public function top_answer($top=1)
	{
		if ( ! $top || $top > $this->get_answers_num()) {
			throw new Exception("The answer does not exist !");
		} else {
			$num = 0;
			$answer_list = $this->answers();
			foreach ($answer_list as $answer) {
				$num++;
				if ($num === $top) {
					return $answer;
				}
			}
		}
	}

	/**
	 * 获取问题浏览数
	 * @return integer 浏览数
	 */
	public function visit_times()
	{
		$this->parser();
		$times = (int)$this->dom->find('div.zg-gray-normal strong', 0)->plaintext;
		return $times;
	}
}