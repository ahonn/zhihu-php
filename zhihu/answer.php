<?php

/**
 * 知乎答案类 Answer
 */
class Answer
{
	private $url;
	private $question;
	private $author;
	private $upvote;
	private $content;
	private $dom;

	function __construct($url, Question $question = null, User $author = null, $upvote = null, $content = null)
	{
		$this->url = $url;
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

	/**
	 * 解析user_url为simple html dom对象
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
	 * 获取 URL
	 * @return string URL
	 */
	public function url()
	{
		return $this->url;
	}

	/**
	 * 获取答案所在问题
	 * @return object Question对象
	 */
	public function question()
	{
		if(empty($this->question)) {
			$this->parser();
			$question_link = $this->dom->find('div#zh-question-title a',0);
			$question_url = ZHIHU_URL.$question_link->href;
			$title = $question_link->plaintext;
			$this->question = new Question($question_url, $title);
		}
		return $this->question;
	}

	/**
	 * 获取回答作者
	 * @return object User对象
	 */
	public function author()
	{
		if (empty($this->author)) {
			$this->parser();
			$author_link = $this->dom->find('h2.zm-list-content-title', 0);

			$author_name = $author_link->plaintext;
			if ($author_name != '匿名用户') {
				$author_url = $author_link->find('a', 0)->href;
			} else {
				$author_url = null;
			}
			$this->author = new User($author_url, $author_name);
		}
		return $this->author;
	}


	/**
	 * 获取回答赞同数
	 * @return string 赞同数
	 */
	public function upvote()
	{
		if (empty($this->upvote)) {
			$this->parser();
			$upvote_link = $this->dom->find('div#zh-question-answer-wrap', 0);

			if ( ! empty($upvote_link->find('button.up span', 0))) {
				$this->upvote = $upvote_link->find('button.up span', 0)->plaintext;
			} else {
				$this->upvote = $this->dom->find('div.zm-item-vote a', 0)->plaintext;
			}
		}
		return $this->upvote;
	}

	/**
	 * 获取答案内容
	 * @return string 答案内容
	 */
	public function content()
	{
		if (empty($this->content)) {
			$this->parser();
			$this->content = $this->dom->find('div#zh-question-answer-wrap div.zm-editable-content', 0)->plaintext;
		}
		return $this->content;
	}


	/**
	 * 获取该答案下的评论
	 * @return Generator 评论列表迭代器
	 */
	public function comment()
	{
		$this->parser();
		$answer_id = $this->dom->find('div.zm-item-answer', 0)->attr['data-aid'];
		$comment_url = str_replace("{id}", $answer_id, COMMENT_LIST_URL.GET_PAGE_SUFFIX_URL);
		for ($page = $pages = 1; $page <= $pages; $page++) { 
			$page_url = $comment_url.$page;
			$r = Request::get($page_url, array("Referer: {$this->url}"));
			$json = json_decode($r);
			
			if ($page == 1) {
				$totalCount = (int)$json->paging->totalCount;
				$pages = ceil($totalCount / 30);
			}
			
			$comments = $json->data;
			foreach ($comments as $comment) {
				$author_name = $comment->author->name;
				$author_url = str_replace('http', 'https', $comment->author->url);
				$author = new User($author_url, $author_name);

				if ( ! empty($comment->inReplyToUser)) {
					$replyed_name = $comment->inReplyToUser->name;
					$replyed_url = str_replace('http', 'https', $comment->inReplyToUser->url);
					$replyed = new User($replyed_url, $replyed_name);
				} else {
					$replyed = null;
				}

				$content = $comment->content;

				yield new Comment($author, $content, $time = null, $replyed);
			}
		}
	}

	/**
	 * 获取该答案被收藏数
	 * @return integer 收藏数
	 */
	public function collection_num()
	{
		$this->parser();
		if ( ! empty($collection_num = $this->dom->find('div.zm-side-section-inner h3 a', 0))) {
			$collection_num = (int)$collection_num->plaintext;
		} else {
			$collection_num = 0;
		}
		return $collection_num;
	}


	/**
	 * 获取收藏该回答的收藏夹列表
	 * @return Generator 收藏夹列表
	 */
	public function collection()
	{
		$collection_num = $this->collection_num();
		if ($collection_num == 0) {
			yield null;
		} else {
			$collection_url = $this->url.COLLECTION_SUFFIX_URL;
			$r = Request::get($collection_url);
			$dom = str_get_html($r);

			$_xsrf = $dom->find('input[name=_xsrf]', 0)->attr['value'];
			$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];

			for ($i = 0; $i < $collection_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($collection_num, 20); $j++) { 
						$collection = $dom->find('div.zm-item', $j);
						yield parser_collection_from_answer($collection);	
					}
				} else {
					$post_url = COLLECTION_LIST_URL;
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 20;
					$params = json_encode($params);
					
					$data = array(
						'method' => 'next',
						'params' => $params,
						'_xsrf' => $_xsrf
					);

					$r = Request::post($post_url, $data, array("Referer: {$collection_url}"));
					$r = json_decode($r)->msg;

					for ($j = 0; $j < count($r); $j++) { 
						$dom = str_get_html($r[$j]);
						$collection = $dom->find('div.zm-item', 0);
						yield parser_collection_from_answer($collection);
					}
				}
			}
		}
	}


	/**
	 * 获取点赞该回答的用户
	 * @return Generator 点赞用户迭代器
	 */
	public function voters()
	{
		$this->parser();
		$answer_id = $this->dom->find('div.zm-item-answer', 0)->attr['data-aid'];

		$voters_url = ANSWERS_PREFIX_URL.$answer_id.VOTERS_SUFFIX_URL;
		echo $voters_url;
		while (true) {
			$r = Request::get($voters_url);
			$response_json = json_decode($r);
			if ( ! empty($response_json->paging->next)) {
				$voters_url = ZHIHU_URL.$response_json->paging->next;
				$voters = $response_json->payload;
				foreach ($voters as $voter) {
					$dom = str_get_html($voter);
					$voter_link = $dom->find('div.body a', 0);
					yield parser_user($voter_link);
				}
			} else {
				break;
			}
		}
	}

	/**
	 * 获取问题被浏览次数
	 * @return integer 浏览数
	 */
	public function visit_times()
	{
		$this->parser();
		$visit_times = (int)$this->dom->find('div.zh-answer-status p strong', 0)->plaintext;
		return $visit_times;
	}
}
