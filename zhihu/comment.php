<?php
/**
 * 知乎评论类 Comment
 */
class Comment
{
	private $author;
	private $replyed;
	private $content;
	private $time;

	function __construct(User $author, $content, $time, $replyed)
	{
		$this->author = $author;
		$this->content = $content;
		$this->time = $time;

		if ( ! empty($replyed)) {
			$this->replyed = $replyed;
		}
	}

	/**
	 * 获取评论作者
	 * @return object 评论作者
	 */
	public function get_author()
	{
		return $this->author;
	}


	/**
	 * 获取评论内容
	 * @return string 评论内容
	 */
	public function get_content()
	{
		return $this->content;
	}


	/**
	 * 获取评论时间
	 * @return string 评论时间
	 */
	public function get_time()
	{
		return $this->time;
	}


	/**
	 * 获取被回复者
	 * @return object 被回复的用户
	 */
	public function get_replyed()
	{
		if ( ! empty($this->replyed)) {
			return $this->replyed;
		} else {
			return null;
		}
	}
}