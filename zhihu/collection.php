<?php

/**
 * 知乎收藏夹类 Collection
 */
class Collection
{
	public $url;
	private $title;
	private $author;

	function __construct($url, $title=null, $author=null)
	{
		if (substr($url, 0, 33) !== COLLECTION_PREFIX_URL) {
			throw new Exception($url.": it isn't a collection url !");
		} else {
			$this->url = $url;
			if ( ! empty($title)) {
				$this->title = $title;
			}
			if ( ! empty($author)) {
				$this->author = $author;
			}
		}	
	}
	
	/**
	 * 解析收藏主页
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
	 * 获取收藏夹名称
	 * @return string 收藏夹名称
	 */
	public function title()
	{
		if( ! empty($this->title)) {
			$title = $this->title;
		} else {
			$this->parser();
			$title = trim($this->dom->find('div#zh-list-title', 0)->plaintext);
		}
		return $title;
	}

	/**
	 * 获取收藏夹描述
	 * @return string 收藏夹描述
	 */
	public function description()
	{
		$this->parser();
		$description = $this->dom->find('div#zh-fav-head-description', 0)->plaintext;
		return $description;
	}

	/**
	 * 获取收藏夹创建者
	 * @return object 创建者
	 */
	public function author()
	{
		if( ! empty($this->author)) {
			$author = $this->author;
		} else {
			$this->parser();
			$author_link = $this->dom->find('h2.zm-list-content-title a', 0);
			$author_url = ZHIHU_URL.$author_link->href;
			$author_id = $author_link->plaintext;
			$author =  new User($author_url, $author_id);
		}
		return $author;
	}


	/**
	 * 获取收藏夹中的全部回答
	 * @return Generator 回答迭代器
	 */
	public function answers()
	{
		$this->parser();
		$max_page = (int)$this->dom->find('div.zm-invite-pager span', -2)->plaintext;
		for ($i = 1; $i <= $max_page; $i++) { 
			$page_url = $this->url.GET_PAGE_SUFFIX_URL.$i;
			$r = Request::get($page_url);
			$dom = str_get_html($r);

			for ($j = 0; ! empty($dom->find('div.zm-item', $j)); $j++) { 
				$collection_link = $dom->find('div.zm-item', $j);
				if ( ! empty($question_link = $collection_link->find('h2.zm-item-title a', 0))) {
					$question_url = ZHIHU_URL.$question_link->href;
					$question_title = $question_link->plaintext;

					$question = new Question($question_url, $question_title);
				}
				
				$answer_id = $collection_link->find('div.zm-item-answer', 0)->attr['data-atoken'];
				$answer_url = $question_url.'/answer'.$answer_id;

				if ( ! empty($author_link = $collection_link->find('div.zm-item-answer-author-info a', 0))) {
					$author_url = ZHIHU_URL.$author_link->href;
					$author_name = $author_link->plaintext;
				} else {
					$author_url = null;
					$author_name = '匿名用户';
				}
				$author = new User($author_url, $author_name);

				$upvote = $collection_link->find('div.zm-item-vote a', 0)->plaintext;

				if ( ! empty($content = $collection_link->find('textarea.content', 0))) {
					$content = $content->plaintext;
				} else {
					$content = trim($collection_link->find('div.answer-status p', 0)->plaintext);
				}
				yield new Answer($answer_url, $question, $author, $upvote, $content);
			}
		}
	}
}