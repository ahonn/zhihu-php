<?php

/**
 * 知乎用户类 User
 */
class User 
{
	private $url;
	private $name;
	private $dom;
	private $about_dom;

	function __construct($url, $name=null)
	{
		if (empty($url)) {
			$this->name = '匿名用户';
		} elseif (substr($url, 0, 29) !== USER_PREFIX_URL) {
			throw new Exception($url.": it isn't a user url !");
		} else {
			$this->url = $url;
			if ( ! empty($name)) {
				$this->name = $name;
			}
		}	
	}


	/**
	 * 解析用户主页
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
	 * 获取用户名
	 * @return string 用户名
	 */
	public function name()
	{
		if (empty($this->name)) {
			$this->parser();
			$this->name = trim($this->dom->find('div.zm-profile-header span.name', 0)->plaintext);
		}
		return $this->name;
	}


	/**
	 * 获取用户头像
	 * @return string 用户头像url
	 */
	public function avatar()
	{
		if (empty($this->url)) {
			return 'http://pic1.zhimg.com/da8e974dc_r.jpg';
		} else {
			$this->parser();
			$avatar = $this->dom->find('img.Avatar', 0)->srcset;
			$avatar = str_replace("_xl", "", explode(' ', $avatar, 2)[0]);
			return $avatar;
		}
	}

	/**
	 * 获取用户性别
	 * @return string 用户性别
	 */
	public function gender()
	{
		if (empty($this->url)) {
			return null;
		} else {
			if ( ! empty($gender_link = $this->dom->find('div.item span.gender', 0))) {
				if ( ! empty($gender_link->find('i.icon-profile-male'))) {
					$gender = 'male';
				} elseif ( ! empty($gender_link->find('i.icon-profile-female'))) {
					$gender = 'female';
				}
			} else {
				$gender = null;
			}
			return $gender;
		}
	}

	/**
	 * 获取用户个人简介
	 * @return string 用户个人简介
	 */
	public function desc()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$description_link = $this->dom->find('div.zm-profile-header-description span.description', 0);
			if ( ! empty($description_link)) {
				$description = trim($description_link->find('[class!=collapse]', 0)->plaintext);
				if ($description == '') {
					$description = null;
				}
			} else {
				$description = null;
			}
			return $description;
		}
	}

	/**
	 * 获取用户微博链接
	 * @return string 微博链接
	 */
	public function weibo_url()
	{
		if (empty($this->url)) {
			return null;
		} else {
			if ( ! empty($this->dom->find('a.zm-profile-header-user-weibo', 0))) {
				$weibo_url = $this->dom->find('a.zm-profile-header-user-weibo', 0)->href;
			} else {
				$weibo_url = null;
			}
			return $weibo_url;
		}
	}

	/**
	 * 获取用户居住地
	 * @return string 用户居住地
	 */
	public function location()
	{
		return $this->parser_about('location');
	}

	/**
	 * 获取用户所在行业
	 * @return string 所在行业
	 */
	public function business()
	{
		return $this->parser_about('business');
	}

	/**
	 * 获取用户公司信息
	 * @return string 用户公司信息
	 */
	public function employment()
	{
		return $this->parser_about('employment');
	}

	/**
	 * 获取用户职位
	 * @return string 用户职位
	 */
	public function position()
	{
		return $this->parser_about('position');
	}


	/**
	 * 获取用户学校信息
	 * @return string [获取用户学校信息]
	 */
	public function education()
	{
		return $this->parser_about('education');
	}


	/**
	 * 获取用户专业
	 * @return string 用户专业
	 */
	public function major()
	{
		return $this->parser_about('education-extra');
	}

	/**
	 * 获取用户资料
	 * @param  string $key 类别
	 * @return string            对应信息
	 */
	public function parser_about($key)
	{
		if (empty($this->url)) {
			return null;
		} else {
			if (empty($this->about_dom)) {
				$about_url = $this->url.'/about';
				$r = Request::get($about_url);
				$this->about_dom = str_get_html($r);
			}
			if ($this->about_dom->find("div.item span.{$key}", 0)->title) {
				$value = $this->about_dom->find("div.item span.{$key}", 0)->title;
			} else {
				$value = null;
			}
			return $value;
		}
	}

	/**
	 * 获取用户信息
	 * @return string 用户信息
	 */
	public function about()
	{
		$about = array(
			'name'	=>	$this->name(),
			'avatar'	=>	$this->avatar(),
			'weibo_url'	=>	$this->weibo_url(),
			'location'	=>	$this->location(),
			'business'	=>	$this->business(),
			'gender'	=>	$this->gender(),
			'employment'=>	$this->employment(),
			'position'	=>	$this->position(),
			'education'	=>	$this->education(),
			'major'	=>	$this->major(),
			'desc'	=>	$this->desc()
		);
		return $about;
	}

	/**
	 * 获取用户关注数
	 * @return integer 关注人数
	 */
	public function followees_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$followees_num = $this->dom->find('div.zm-profile-side-following strong', 0)->plaintext;
			return (int)$followees_num;
		}	
	}

	/**
	 * 获取用户粉丝数
	 * @return integer 粉丝人数
	 */
	public function followers_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$followers_num = $this->dom->find('div.zm-profile-side-following strong', 1)->plaintext;
			return (int)$followers_num;
		}
	}

	/**
	 * 获取用户赞同数
	 * @return integer 赞同数
	 */
	public function agree_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$agree_num = $this->dom->find('div.zm-profile-header-info-list strong', 0)->plaintext;
			return (int)$agree_num;
		}
	}


	/**
	 * 获取用户感谢数
	 * @return integer 感谢数
	 */
	public function thanks_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$thanks_num = $this->dom->find('div.zm-profile-header-info-list strong', 1)->plaintext;
			return (int)$thanks_num;
		}
	}

	/**
	 * 获取用户提问数
	 * @return integer 提问数
	 */
	public function asks_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$asks_num = $this->dom->find('span.num', 0)->plaintext;
			return (int)$asks_num;
		}
	}

	/**
	 * 获取用户回答数
	 * @return integer 回答数
	 */
	public function answers_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$answers_num = $this->dom->find('span.num', 1)->plaintext;
			return (int)$answers_num;
		}
	}


	/**
	 * 获取用户专栏文章数
	 * @return integer 专栏文章数
	 */
	public function posts_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$posts_num = $this->dom->find('span.num', 2)->plaintext;
			return (int)$posts_num;
		}
	}

	# TODO: 获取用户专栏文章

	/**
	 * 获取用户收藏数
	 * @return integer 收藏数
	 */
	public function collections_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$collections_num = $this->dom->find('span.num', 3)->plaintext;
			return (int)$collections_num;
		}
	}

	/**
	 * 获取用户收藏夹
	 * @return  Generator 收藏夹生成器
	 */
	public function collections()
	{
		$collections_num = $this->collections_num();
		if ($collections_num == 0) {
			yield null;
		} else {
			$collections_url = $this->url.'/collections';
			$r = Request::get($collections_url);
			$dom = str_get_html($r);

			for ($i = 0; ! empty($collection_link = $dom->find('a.zm-profile-fav-item-title', $i)); $i++) { 
				$collection_url = ZHIHU_URL.$collection_link->href;
				$collection_title = trim($collection_link->plaintext);
				yield new Collection($collection_url, $collection_title, $this);
			}
		}
	}

	/**
	 * 获取用户关注话题数
	 * @return integer 用户关注话题数
	 */
	public function topics_num()
	{
		if (empty($this->url)) {
			return 0;
		} else {
			$this->parser();
			$topics_num = $this->dom->find('div.zm-profile-side-section strong', 1)->plaintext;
			$topics_num = explode(' ', $topics_num, 2)[0];
			return (int)$topics_num;
		}
	}


	/**
	 * 获取用户关注的话题列表
	 * @return Generator 话题生成器
	 */
	public function topics()
	{
		$topics_num = $this->topics_num();
		if ($topics_num == 0) {
			yield null;
		} else {
			$topics_url = $this->url.TOPICS_SUFFIX_URL;
			$r = Request::get($topics_url);
			$dom = str_get_html($r);

			$_xsrf = $dom->find('input[name=_xsrf]', 0)->attr['value'];
			for ($i = 0; $i < $topics_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($topics_num, 20); $j++) { 
						$topics_link =  $dom->find('div.zm-profile-section-main', $j);
						yield parser_topics_from_user($topics_link);
					}
				} else {
					$data = array(
						'start' => 0,
						'offset' => $i * 20,
						'_xsrf' => $_xsrf
					);

					$r = Request::post($topics_url, $data, array("Referer: {$topics_url}"));
					$r = json_decode($r)->msg;

					$dom = str_get_html($r[1]);
					for ($j = 0; $j < min(($topics_num - $i * 20), 20); $j++) { 
						$topics_link = $dom->find('div.zm-profile-section-main', $j);		
						yield parser_topics_from_user($topics_link);		
					}
				}
			}
		}
	}

	/**
	 * 获取用户关注列表
	 * @return Generator 关注列表
	 */
	public function followees()
	{
		return $this->follow('FOLLOWEES');
	}


	/**
	 * 获取用户粉丝列表
	 * @return Generator 粉丝列表
	 */
	public function followers()
	{
		return $this->follow('FOLLOWERS');
	}

	/**
	 * 获取用户列表
	 * @param  String $type 关注或者粉丝
	 * @return Generator  用户列表
	 */
	private function follow($type)
	{
		if ($type === 'FOLLOWERS') {
			$num = $this->followers_num();
			$url = $this->url.FOLLOWERS_SUFFIX_URL;
			$post_url = FOLLOWERS_LIST_URL;
		} elseif ($type === 'FOLLOWEES') {
			$num = $this->followees_num();
			$url = $this->url.FOLLOWEES_SUFFIX_URL;
			$post_url = FOLLOWEES_LIST_URL;
		} 

		if ($num <= 0) {
			return null;
		} else {
			$r = Request::get($url);			
			$dom = str_get_html($r);
			$_xsrf = _xsrf($dom);
		  	$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];
		
			for ($i = 0; $i < $num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($num, 20); $j++) { 
						$user_list = $dom->find('a.zg-link', $j);
						yield parser_user($user_list);
					}
				} else {
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 20;
					$params = json_encode($params);

					$data = array(
						'_xsrf' => $_xsrf,
						'method' => 'next',
						'params' => $params
					);

					$r = Request::post($post_url, $data, array("Referer: {$url}" ));
					$r = json_decode($r)->msg;
					for ($j = 0; $j < min($num - $i * 20, 20); $j++) { 
						$dom = str_get_html($r[$j]);
						$user_list = $dom->find('a.zg-link', 0);
						yield parser_user($user_list);					
					}
				}
			}
		}
	}

	/**
	 * 获取用户提问列表
	 * @return Generator 提问列表生成器
	 */
	public function asks()
	{
		if (empty($this->url)) {
			yield null;
		} else {
			$asks_num = $this->asks_num();
			if ($asks_num == 0) {
				yield null;
			} else {
				for ($i = 0; $i < $asks_num / 20; $i++) { 
					$ask_url = $this->url.ASKS_PAGE_SUFFIX_URL.($i+1);
					$r = Request::get($ask_url);
					$dom = str_get_html($r);

					for ($j = 0; $j < min($asks_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);
						yield parser_question($question_link);
					} 
				}
			}
		}
	}

	/**
	 * 获取用户回答列表
	 * @return Generator 回答列表生成器
	 */
	public function answers()
	{
		if (empty($this->url)) {
			yield null;
		} else {
			$answers_num = $this->answers_num();
			if ($answers_num == 0) {
				yield null;
			} else {
				for ($i = 0; $i < $answers_num / 20; $i++) { 
					$answer_page_url = $this->url.ANSWERS_PAGE_SUFFIX_URL.($i+1);

					$r = Request::get($answer_page_url);
					$dom = str_get_html($r);

					for ($j = 0; $j < min($answers_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);

						$answer_url = ZHIHU_URL.$question_link->href;
						$question = parser_question($question_link);
						yield new Answer($answer_url, $question);
					}
				}
			}
		}
	}
}
