<?php

class Topic 
{
	private $url;
	private $name;
	private $dom;
	private $entire_dom;

	function __construct($url, $name = null)
	{
		if (substr($url, 0, 28) != TOPICS_PREFIX_URL) {
			throw new Exception($url.": it isn't a topics url !");
		} else {
			$this->url = $url;
			if ( ! empty($name)) {
				$this->name = $name;
			}
		}
	}

	/**
	 * 解析话题主页
	 * @return object simple html dom 对象
	 */
	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->url);
			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 解析话题结构
	 * @return object simple html dom
	 */
	public function parser_entire()
	{
		if (empty($this->entire_dom)) {
			$entire_url = $this->url.'/organize';
			$this->entire_dom = str_get_html(Request::get($entire_url));	
		}
		return $this->entire_dom;
	}

	/**
	 * 获取 URL
	 * @return string URL
	 */
	public function url()
	{
		return $this->url;
	}

	/**
	 * 获取该话题的名称
	 * @return string 话题名称
	 */
	public function name()
	{
		if ( ! empty($this->name)) {
			return $this->name;
		} else {
			$this->parser();
			$this->name = $this->dom->find('h1', 0)->plaintext;
			return $this->name;
		}
	}

	/**
	 * 获取话题描述
	 * @return string 话题描述
	 */
	public function description()
	{
		$this->parser();
		$description = trim($this->dom->find('div#zh-topic-desc div.zm-editable-content', 0)->plaintext);
		if ($description === '') {
			$description = null;
		}
		return $description;
	}


	/**
	 * 获取关注该话题的人数
	 * @return integer 话题关注人数
	 */
	public function followers()
	{
		$this->parser();
		$followers_num = (int)$this->dom->find('div.zm-topic-side-followers-info strong', 0)->plaintext;
		return $followers_num;
	}

	/**
	 * 获取该话题的父话题
	 * @return array 父话题列表
	 */
	public function parent()
	{
		$dom = $this->parser_entire();
		for ($i = 0; ! empty($parent_link = $dom->find('div#zh-topic-organize-parent-editor a', $i)); $i++) { 
			$parent_url = ZHIHU_URL.substr($parent_link->href, 0 , 15);
			$parent_name = trim($parent_link->plaintext);
			yield new Topic($parent_url, $parent_name);
		}
	}

	/**
	 * 获取该话题的子话题
	 * @return array 子话题列表
	 */
	public function children()
	{
		$dom = $this->parser_entire();
		for ($i = 0; ! empty($children_link = $dom->find('div#zh-topic-organize-child-editor a', $i)); $i++) { 
				$children_url = ZHIHU_URL.substr($children_link->href, 0, 15);
				$children_name = trim($children_link->plaintext);
				yield new Topic($children_url, $children_name);
		}
	}

	/**
	 * 获取该话题下的最佳回答者
	 * @return array 最佳回答者列表
	 */
	public function answerer()
	{
		$this->parser();
		for ($i = 0; ! empty($dom = $this->dom->find('div.zm-topic-side-person-item', $i)) ; $i++) { 
			$answerer_link = $dom->find('a', 1);
			$answerer_url = ZHIHU_URL.$answerer_link->href;
			$answerer_name = trim($answerer_link->plaintext);
			yield new User($answerer_url, $answerer_name);
		}
	}

	/**
	 * 获取该话题下热门问题
	 * @return Generator 热门问题列表
	 */
	public function hot_question()
	{
		$hot_question_url = $this->url.TOPICS_HOT_SUFFIX_URL;
		return $this->question($hot_question_url);
	}

	/**
	 * 获取该话题下最新问题
	 * @return Generator 最新问题列表
	 */
	public function new_question()
	{
		$new_question_url = $this->url.TOPICS_NEW_SUFFIX_URL;
		return $this->question($new_question_url);
	}

		/**
	 * 获取该话题下全部问题
	 * @return Generator 全部的问题
	 */
	public function all_question()
	{
		$all_question_url = $this->url.TOPICS_ALL_SUFFIX_URL;
		$r = Request::get($all_question_url);
		$dom = str_get_html($r);
		$max_page = (int)$dom->find('div.zm-invite-pager span', -2)->plaintext;

		for ($i = 1; $i <= $max_page; $i++) { 
			if ($i > 1) {
				$page_url = $all_question_url.GET_PAGE_SUFFIX_URL.$i;
				$r = Request::get($page_url);
				$dom = str_get_html($r);
			}

			for ($j = 0; ! empty($dom->find('h2 a.question_link', $j)); $j++) { 
				$question_link = $dom->find('h2 a.question_link', $j);
				yield parser_question($question_link);	
			}
		}
	}


	/**
	 * 获取问题列表
	 * @param  string $url 目标 url
	 * @return Generator   问题迭代器
	 */		
	private function question($url)
	{
		$r = Request::get($url);
		$dom = str_get_html($r);

		$_xsrf = _xsrf($dom);
		$tmp_url = null;
		for ($i = 0; ! empty($combine = $dom->find('div.feed-item', $i)); $i++) { 
			$offset = $combine->attr['data-score'];

			$question_link = $combine->find('h2 a.question_link', 0);
			$question_url = ZHIHU_URL.$question_link->href;
			if ($question_url != $tmp_url) {
				$tmp_url = $question_url;
				$question_title = $question_link->plaintext;
				yield new Question($question_url, $question_title);
			}
		}
		do {
			$data = array(
				'start' => 0,
				'offset' => $offset,
				'_xsrf' => $_xsrf
			);
			$r = Request::post($url, $data, array('Referer: {$url}"'));
			$r = json_decode($r)->msg;
			$item = $r[0];
			$dom = str_get_html($r[1]);

			for ($i = 0; $item && ! empty($combine = $dom->find('div.feed-item', $i)) ; $i++) { 
				$offset = $combine->attr['data-score'];

				$question_link = $combine->find('h2 a.question_link', 0);
				$question_url = ZHIHU_URL.$question_link->href;
				if ($question_url != $tmp_url) {
					$tmp_url = $question_url;
					$question_title = $question_link->plaintext;
					yield new Question($question_url, $question_title);
				}
			}
		} while ($item);
	}


	/**
	 * 获取该话题下精华回答
	 * @return Generator 精华回答列表
	 */
	public function top_answer()
	{
		$top_answer_url = $this->url.TOPICS_TOP_SUFFIX_URL;
		$r = Request::get($top_answer_url);
		$dom = str_get_html($r);
		$max_page = (int)$dom->find('div.zm-invite-pager span', -2)->plaintext;

		for ($i = 1; $i <= $max_page; $i++) { 
			if ($i > 1) {
				$page_url = $top_answer_url.GET_PAGE_SUFFIX_URL.$i;
				$r = Request::get($page_url);
				$dom = str_get_html($r);
			}

			for ($j = 0; ! empty($item = $dom->find('div.feed-item', $j)); $j++) { 
				$answer_url = ZHIHU_URL.$item->find('div.zm-item-rich-text', 0)->attr['data-entry-url'];

				$question_link = $item->find('h2 a.question_link', 0);
				$question =  parser_question($question_link);

				$author_link = $item->find('div.zm-item-answer-author-info a', 0);
				$author = parser_user_from_topic($author_link);

				$upvote = $item->find('span.count', 0)->plaintext;
				$content = $item->find('textarea.content', 0)->plaintext;

				yield new Answer($answer_url, $question, $author, $upvote, $content);	
			}
		}
	}
}