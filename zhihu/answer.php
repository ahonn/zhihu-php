<?php

/**
 * 知乎答案类 Answer
 */
class Answer
{
	public $url;
	private $question;
	private $author;
	private $upvote;
	private $content;

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
		if (empty($this->dom) || ! isset($this->dom)) {
			$r = Request::get($this->url);
			$this->dom = str_get_html($r);
		}
	}


	/**
	 * 获取答案所在问题
	 * @return object Question对象
	 */
	public function get_question()
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
	public function get_author()
	{
		if (empty($this->author)) {
			$this->parser();
			$author_link = $this->dom->find('h2.zm-list-content-title', 0);

			$author_id = $author_link->plaintext;
			if ($author_id != '匿名用户') {
				$author_url = $author_link->find('a', 0)->href;
			} else {
				$author_url = null;
			}
			$this->author = new User($author_url, $author_id);
		}
		return $this->author;
	}


	/**
	 * 获取回答赞同数
	 * @return integer 赞同数
	 */
	public function get_upvote()
	{
		if (empty($this->upvote)) {
			$this->parser();
			$upvote_link = $this->dom->find('div#zh-question-answer-wrap', 0);

			if ( ! empty($upvote_link->find('button.up span', 0))) {
				$this->upvote = (int)$upvote_link->find('button.up span', 0)->plaintext;
			} else {
				$this->upvote = (int)$this->dom->find('div.zm-item-vote a', 0)->plaintext;
			}
		}
		return $this->upvote;
	}

	/**
	 * 获取答案内容
	 * @return string 答案内容
	 */
	public function get_content()
	{
		if (empty($this->content)) {
			$this->parser();
			$content = $this->dom->find('div#zh-question-answer-wrap div.zm-editable-content', 0)->plaintext;
		}
		return $content;
	}


	/**
	 * 获取该答案下的评论
	 * @return Generator 评论列表迭代器
	 */
	public function get_comment()
	{
		$this->parser();
		$answer_id = $this->dom->find('div.zm-item-answer', 0)->attr['data-aid'];
		$date = '?params=%7B%22answer_id%22%3A%22'.$answer_id.'%22%2C%22load_all%22%3Atrue%7D';
		$get_url = COMMENT_LIST_URL.$date;

		$r = Request::get($get_url);
		$dom = str_get_html($r);
		
		for ($i = 0; ! empty($dom->find('div.zm-item-comment', $i)); $i++) { 
			$comment_link = $dom->find('div.zm-item-comment', $i);
			
			$author_url = $comment_link->find('div.zm-comment-hd a', 0)->href;
			$author_id = $comment_link->find('div.zm-comment-hd a', 0)->plaintext;
			$author = new User($author_url, $author_id);

			$content = $comment_link->find('div.zm-comment-content', 0)->plaintext;

			$time = $comment_link->find('span.date', 0)->plaintext;

			if ( ! empty($comment_link->find('div.zm-comment-hd a', 1))) {
				$reply_url = $comment_link->find('div.zm-comment-hd a', 1)->href;
				$reply_id = $comment_link->find('div.zm-comment-hd a', 1)->plaintext;
				$reply = new User($reply_url, $reply_id);
			} else {
				$reply = null;
			}

			yield new Comment($author, $content, $time, $reply);
		}
	}

	/**
	 * 获取该答案被收藏数
	 * @return integer 收藏数
	 */
	public function get_collection_num()
	{
		$this->parser();
		if ( ! empty($this->dom->find('div.zm-side-section-inner h3 a', 0))) {
			$collection_num = (int)$this->dom->find('div.zm-side-section-inner h3 a', 0)->plaintext;
		} else {
			$collection_num = 0;
		}
		return $collection_num;
	}


	/**
	 * 获取收藏该回答的收藏夹列表
	 * @return Generator 收藏夹列表
	 */
	public function get_collection()
	{
		$collection_num = $this->get_collection_num();
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
						$link = $dom->find('div.zm-item', $j);

						$collection_link = $link->find('h2 a', 0);
						$collection_url = ZHIHU_URL.$collection_link->href;
						$collection_title = $collection_link->plaintext;

						if ( ! empty($link->find('div a[class!=zg-unfollow]', 0))) {
							$author_link = $link->find('div a[class!=zg-unfollow]', 0);
							$author_url = $author_link->href;
							$author_id = $author_link->plaintext;
							$collection_author = new User($author_url, $author_id);
						} else {
							$collection_author = null;
						}
						
						yield new Collection($collection_url, $collection_title, $collection_author);
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

					for ($j = 0; $j < min($collection_num - $i *20, 20); $j++) { 
						$dom = str_get_html($r[$j]);

						$link = $dom->find('div.zm-item', 0);

						$collection_link = $link->find('h2 a', 0);
						$collection_url = ZHIHU_URL.$collection_link->href;
						$collection_title = $collection_link->plaintext;

						if ( ! empty($link->find('div a[class!=zg-unfollow]', 0))) {
							$author_link = $link->find('div a[class!=zg-unfollow]', 0);
							$author_url = $author_link->href;
							$author_id = $author_link->plaintext;
							$collection_author = new User($author_url, $author_id);
						} else {
							$collection_author = null;
						}
						
						yield new Collection($collection_url, $collection_title, $collection_author);
					}
				}
			}
		}
	}


	/**
	 * 获取点赞该回答的用户
	 * @return Generator 点赞用户迭代器
	 */
	public function get_voters()
	{
		$this->parser();
		$answer_id = $this->dom->find('div.zm-item-answer', 0)->attr['data-aid'];

		$voters_url = ANSWERS_PREFIX_URL.$answer_id.VOTERS_SUFFIX_URL;
		while ($voters_url) {
			$r = Request::get($voters_url);
			$response_json = json_decode($r);

			$voters = $response_json->payload;
			$voters_url = ZHIHU_URL.$response_json->paging->next;
			
			foreach ($voters as $voter) {
				$dom = str_get_html($voter);
				if ( ! empty($dom->find('div.author a', 0))) {
					$voter_link = $dom->find('div.author a', 0);

					$voter_url = $voter_link->href;
					$voter_name = $voter_link->plaintext;
				} else {
					$voter_url = null;
					$voter_name = $dom->find('div.body', 0)->plaintext;
				}

				yield new User($voter_url, $voter_name);
			}
		}
	}

	/**
	 * 获取问题被浏览次数
	 * @return integer 浏览数
	 */
	public function get_visit_times()
	{
		$this->parser();
		$visit_times = (int)$this->dom->find('div.zh-answer-status p strong', 0)->plaintext;
		return $visit_times;
	}
}
