<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-14 19:25:21
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-14 21:52:03
 */

require_once 'lib/simple_html_dom.php';

class User
{
	private $user_url;
	private $user_id;
	private $dom;

	function __construct($user_url, $user_id = null)
	{
		if (substr($user_url, 0, 28) !== "http://www.zhihu.com/people/") {
			throw new Exception($user_url.": it isn't a user url !");
		} 
		else {
			$this->user_url = $user_url;
			if ($user_id != null ) {
				$this->user_id = $user_id;
			}
		}	
	}

	/**
	 * 解析user_url为simple html dom对象
	 * @return [Object] [simple html dom 对象]
	 */
	public function parser()
	{
		if ($this->dom == null) {
			$html = new simple_html_dom();
			$html->load_file($this->user_url);
			$this->dom = $html;
		}
	}

	/**
	 * 获取用户ID
	 * @return [string] [用户知乎ID]
	 */
	public function get_user_id()
	{
		if ($this->user_id) {
			return $this->user_id;
		}
		else {
			$this->parser();
			$user_id = $this->dom->find('div.title-section span.name',0)->plaintext;
			$this->user_id = $user_id;
			return $user_id;
		}
	}

	/**
	 * 获取用户关注人数
	 * @return [string] [关注人数]
	 */
	public function get_followees_num()
	{
		$this->parser();
		$followees_num = $this->dom->find('div.zm-profile-side-following strong', 0)->plaintext;
		return $followees_num;
	}

	/**
	 * 获取用户关注者人数
	 * @return [string] [关注者人数]
	 */
	public function get_followers_num()
	{
		$this->parser();
		$followers_num = $this->dom->find('div.zm-profile-side-following strong', 1)->plaintext;
		return $followers_num;
	}

	/**
	 * 获取赞同数
	 * @return [string] [赞同数]
	 */
	public function get_agree_num()
	{
		$this->parser();
		$agree_num = $this->dom->find('div.zm-profile-header-info-list strong', 0)->plaintext;
		return $agree_num;
	}


	/**
	 * 获取感谢数
	 * @return [string] [感谢数]
	 */
	public function get_thanks_num()
	{
		$this->parser();
		$thanks_num = $this->dom->find('div.zm-profile-header-info-list strong', 1)->plaintext;
		return $thanks_num;
	}

	/**
	 * 获取提问数
	 * @return [string] [提问数]
	 */
	public function get_asks_num()
	{
		$this->parser();
		$asks_num = $this->dom->find('span.num', 0)->plaintext;
		return $asks_num;
	}

	/**
	 * 获取回答数
	 * @return [string] [回答数]
	 */
	public function get_answers_num()
	{
		$this->parser();
		$answers_num = $this->dom->find('span.num', 1)->plaintext;
		return $answers_num;
	}

	/**
	 * 获取收藏数
	 * @return [string] [收藏数]
	 */
	public function get_collections_num()
	{
		$this->parser();
		$collections_num = $this->dom->find('span.num', 3)->plaintext;
		return $collections_num;
	}

}

