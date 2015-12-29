<?php

class Topic 
{
	private $topics_url;
	private $topics_id;

	function __construct($topics_url, $topics_id=null)
	{
		if (substr($topics_url, 0, 28) != TOPICS_PREFIX_URL) {
			throw new Exception($topics_url.": it isn't a topics url !");
		} else {
			$this->topics_url = $topics_url;
			if ( ! empty($topics_id)) {
				$this->topics_id = $topics_id;
			}
		}
	}

	/**
	 * 解析话题主页
	 * @return object simple html dom 对象
	 */
	public function parser()
	{
		if (empty($this->dom) || isset($this->dom)) {
			$r = Request::get($this->topics_url);

			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 获取话题描述
	 * @return string 话题描述
	 */
	public function get_description()
	{
		$this->parser();
		$description = $this->dom->find('div#zh-topic-desc div.zm-editable-content', 0)->plaintext;
		return $description;
	}


	/**
	 * 获取关注该话题的人数
	 * @return integer 话题关注人数
	 */
	public function get_followers()
	{
		$this->parser();
		$followers_num = (int)$this->dom->find('div.zm-topic-side-followers-info strong', 0)->plaintext;
		return $followers_num;
	}

	/**
	 * 获取该话题的父话题
	 * @return array 父话题列表
	 */
	public function get_parent()
	{
		$this->parser();
		$parent_link = $this->dom->find('div.parent-topic', 0);

		for ($i = 0; ! empty($parent_link->find('a', $i)) ; $i++) { 
			$parent_url = ZHIHU_URL.$parent_link->find('a', $i)->href;
			$parent_id = $parent_link->find('a', $i)->plaintext;
			$parent_list[] = new Topic($parent_url, $parent_id);
		}
		return $parent_list;
	}

	/**
	 * 获取该话题的子话题
	 * @return array 子话题列表
	 */
	public function get_children()
	{
		if (empty($this->dom->find('a.zm-topic-side-title-link', 0))) {
			return null;
		}
		$children_num = $this->dom->find('a.zm-topic-side-title-link', 0)->plaintext;
		$children_num = (int)explode(' ', $children_num, 3)[1];

		$entire_url = $this->topics_url.'/organize';
		$r = Request::get($entire_url);
		$dom = str_get_html($r);

		for ($i = 0; $i < $children_num; $i++) { 
				$children_link = $dom->find('div#zh-topic-organize-child-editor a', $i);

				$children_url = ZHIHU_URL.substr($children_link->href, 0, 15);
				$children_id = $children_link->plaintext;
				$children_list[] = new Topic($children_url, $children_id);
		}
		return $children_list;
	}

	/**
	 * 获取该话题下的最佳回答者
	 * @return array 最佳回答者列表
	 */
	public function get_answerer()
	{
		$this->parser();
		for ($i = 0; ! empty($this->dom->find('div.zm-topic-side-person-item', $i)) ; $i++) { 
			$answerer_link = $this->dom->find('div.zm-topic-side-person-item', $i)->find('a', 1);
			$answerer_url = ZHIHU_URL.$answerer_link->href;
			$answerer_id = $answerer_link->plaintext;
			$answerer_list[] = new User($answerer_url, $answerer_id);
		}
		return $answerer_list;
	}

	/**
	 * 获取该话题下的热门问题
	 * @return array 热门问题列表
	 */
	public function get_hot_question()
	{
		$hot_question_url = $this->topics_url.TOPICS_HOT_SUFFIX_URL;
		$r = Request::get($hot_question_url);
		$dom = str_get_html($r);

		for ($i = 0; ! empty($dom->find('div.first-combine', $i)); $i++) { 
			$question_link = $dom->find('div.first-combine', $i)->find('h2 a.question_link', 0);
			$question_url = ZHIHU_URL.$question_link->href;
			$question_title = $question_link->plaintext;
			$question_list[] = new Question($question_url, $question_title);
		}
		return $question_list;
	}

	/**
	 * 获取该话题下精华问题
	 * @return array 精华问题列表
	 */
	public function get_top_question()
	{
		$top_question_url = $this->topics_url.TOPICS_TOP_SUFFIX_URL;
		$r = Request::get($top_question_url);
		$dom = str_get_html($r);

		for ($i = 0; ! empty($dom->find('div.feed-item', $i)); $i++) { 
			$question_link = $dom->find('div.feed-item', $i)->find('h2 a.question_link', 0);
			$question_url = ZHIHU_URL.$question_link->href;
			$question_title = $question_link->plaintext;
			$question_list[] = new Question($question_url, $question_title);
		}
		return $question_list;
	}


	/**
	 * 获取该话题下最新的问题
	 * @return array 最新的问题
	 */
	public function get_new_question()
	{
		$new_question_url = $this->topics_url.TOPICS_NEW_SUFFIX_URL;
		$r = Request::get($new_question_url);
		$dom = str_get_html($r);

		for ($i = 0; ! empty($dom->find('div.feed-item', $i)); $i++) { 
			$question_link = $dom->find('div.feed-item', $i)->find('h2 a.question_link', 0);
			$question_url = ZHIHU_URL.$question_link->href;
			$question_title = $question_link->plaintext;
			$question_list[] = new Question($question_url, $question_title);
		}
		return $question_list;
	}
}