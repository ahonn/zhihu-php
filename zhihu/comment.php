<?php
/**
 * 知乎评论类 Comment
 */
class Comment
{
	private $author;
	private $replyed;
	private $content;

	function __construct(User $author, $content, $replyed)
	{
		$this->author = $author;
		$this->content = $content;

		if ( ! empty($replyed)) {
			$this->replyed = $replyed;
		}
	}

	/**
	 * 获取评论作者
	 * @return object 评论作者
	 */
	public function author()
	{
		return $this->author;
	}

	/**
	 * 获取评论内容
	 * @return string 评论内容
	 */
	public function content()
	{
		return $this->content;
	}

	/**
	 * 获取被回复者
	 * @return object 被回复的用户
	 */
	public function replyed()
	{
		if ( ! empty($this->replyed)) {
			return $this->replyed;
		} else {
			return null;
		}
	}
}