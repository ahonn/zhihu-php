<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-14 19:25:21
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-17 16:41:41
 */

require_once 'lib/simple_html_dom.php';
require_once 'request.php';

class User
{
	private $user_url;
	private $user_id;
	private $dom;

	function __construct($user_url, $user_id=null)
	{
		if (empty($user_url)) {
			$this->user_id = '匿名用户';
		}
		elseif (substr($user_url, 0, 29) !== "https://www.zhihu.com/people/") {
			throw new Exception($user_url.": it isn't a user url !");
		} 
		else {
			$this->user_url = $user_url;
			if ( ! empty($user_id)) {
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
		if (empty($this->dom)) {
			$r = Request::get($this->user_url);

			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 获取用户ID
	 * @return [string] [用户知乎ID]
	 */
	public function get_user_id()
	{
		if ( ! empty($this->user_id)) {
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
	 * 获取关注数
	 * @return [int] [关注人数]
	 */
	public function get_followees_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$followees_num = (int)$this->dom->find('div.zm-profile-side-following strong', 0)->plaintext;
			return $followees_num;
		}	
	}

	/**
	 * 获取粉丝数
	 * @return [int] [粉丝人数]
	 */
	public function get_followers_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$followers_num = (int)$this->dom->find('div.zm-profile-side-following strong', 1)->plaintext;
			return $followers_num;
		}
	}

	/**
	 * 获取赞同数
	 * @return [int] [赞同数]
	 */
	public function get_agree_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$agree_num = (int)$this->dom->find('div.zm-profile-header-info-list strong', 0)->plaintext;
			return $agree_num;
		}
	}


	/**
	 * 获取感谢数
	 * @return [int] [感谢数]
	 */
	public function get_thanks_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$thanks_num = (int)$this->dom->find('div.zm-profile-header-info-list strong', 1)->plaintext;
			return $thanks_num;
		}
	}

	/**
	 * 获取提问数
	 * @return [int] [提问数]
	 */
	public function get_asks_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$asks_num = (int)$this->dom->find('span.num', 0)->plaintext;
			return $asks_num;
		}
	}

	/**
	 * 获取回答数
	 * @return [int] [回答数]
	 */
	public function get_answers_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$answers_num = (int)$this->dom->find('span.num', 1)->plaintext;
			return $answers_num;
		}
	}

	/**
	 * 获取收藏数
	 * @return [int] [收藏数]
	 */
	public function get_collections_num()
	{
		if (empty($this->user_url)) {
			return -1;
		}
		else {
			$this->parser();
			$collections_num = (int)$this->dom->find('span.num', 3)->plaintext;
			return $collections_num;
		}
	}

	/**
	 * 获取关注列表
	 * @return [array] [关注列表]
	 */
	public function get_followees()
	{
		$followees_num = $this->get_followees_num();
		if ($followees_num == 0) {
			return;
		}
		else {
			$followee_url = $this->user_url.'/followees';
			$r = Request::get($followee_url);
			
			$dom = str_get_html($r);

			$_xsrf = $dom->find('input[name=_xsrf]', 0)->attr['value'];
			$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];

			for ($i = 0; $i < $followees_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($followees_num, 20); $j++) { 
						$user_url_list[$j] = $dom->find('a.zg-link', $j);
						$followees_list[] = new User($user_url_list[$j]->href, $user_url_list[$j]->title);
					}
				}
				else {
					$post_url = "https://www.zhihu.com/node/ProfileFolloweesListV2";
			
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 20;
					$params = json_encode($params);

					$data = array(
						'_xsrf' => $_xsrf,
						'method' => 'next',
						'params' => $params
					);

					$r = Request::post($post_url, $data, array("Referer: {$followee_url}" ));
					$r = json_decode($r)->msg;

					for ($j = 0; $j < min($followees_num - $i * 20, 20); $j++) { 
						$dom = str_get_html($r[$j]);
						$user_url_list[$j] = $dom->find('a.zg-link', 0);
						$followees_list[] = new User($user_url_list[$j]->href, $user_url_list[$j]->title);						
					}
				}
			}
			return $followees_list;
		}
	}


	/**
	 * 获取粉丝列表
	 * @return [array] [粉丝列表]
	 */
	public function get_followers()
	{
		$followers_num = $this->get_followers_num();
		if ($followers_num == 0) {
			return;
		}
		else {
			$follower_url = $this->user_url.'/followers';
			$r = Request::get($follower_url);
			
			$dom = str_get_html($r);

			$post_url = "https://www.zhihu.com/node/ProfileFollowersListV2";
			$_xsrf = $dom->find('input[name=_xsrf]',0)->value;
		  	$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];
		  	
			for ($i = 0; $i < $followers_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($followers_num, 20); $j++) { 
						$user_list[$j] = $dom->find('a.zg-link', $j);
						$followers_list[] = new User($user_list[$j]->href, $user_list[$j]->title);
					}
				}
				else {
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 20;
					$params = json_encode($params);

					$data = array(
						'_xsrf' => $_xsrf,
						'method' => 'next',
						'params' => $params
					);

					$r = Request::post($post_url, $data, array("Referer: {$follower_url}" ));
					// echo($r);
					$r = json_decode($r)->msg;

					for ($j = 0; $j < min($followers_num - $i * 20, 20); $j++) { 
						$dom = str_get_html($r[$j]);
						$user_list[$j] = $dom->find('a.zg-link', 0);
						$followers_list[] = new User($user_list[$j]->href, $user_list[$j]->title);						
					}
				}
			}
			return $followers_list;
		}
	}


	/**
	 * 获取提问列表
	 * @return [object array] [提问列表]
	 */
	public function get_asks()
	{
		if (empty($this->user_url)) {
			return null;
		}
		else {
			$asks_num = $this->get_asks_num();

			if ($asks_num == 0) {
				return null;
			}
			else {
				for ($i = 0; $i < $asks_num /20; $i++) { 
					$ask_url = $this->user_url.'/asks?page='.($i+1);
					$r = Request::get($ask_url);
					$dom = str_get_html($r);
					for ($j = 0; $j < min($asks_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);
						
					 	$question_url = 'https://www.zhihu.com'.$question_link->href;
					 	$title = $question_link->plaintext;
					 	$asks[] = new Question($question_url, $title);
					} 
				}
				return $asks;
			}
		}
	}

	/**
	 * 获取回答列表
	 * @return [object array] [回答列表]
	 */
	public function get_answers()
	{
		if (empty($this->user_url)) {
			return null;
		}
		else {
			$answers_num = $this->get_answers_num();

			if ($answers_num == 0) {
				return null;
			}
			else {
				for ($i = 0; $i < $answers_num / 20; $i++) { 
					$answer_url = $this->user_url.'/answers?page='.($i+1);
					$r = Request::get($answer_url);
					$dom = str_get_html($r);
					for ($j = 0; $j < min($answers_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);

						$answer_url = $question_link->href;
						$question_url = 'https://www.zhihu.com'.substr($answer_url, 0, 18);
						$title = $question_link->plaintext;

						$question = new Question($question_url, $title);
						$answer[] = new Answer($answer_url, $question);
					}
				}
				return $answer;
			}
		}
	}
}

