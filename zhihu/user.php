<?php

/**
 * 知乎用户类 User
 */
class User 
{
	public $url;
	private $name;

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
		if (empty($this->dom) || ! isset($this->dom)) {
			$r = Request::get($this->url);

			$this->dom = str_get_html($r);
		}
	}


	/**
	 * 解析用户about页
	 * @return object simple html dom 对象
	 */
	public function parser_about()
	{
		if (empty($this->about_dom)) {
			$user_info_url = $this->url.'/about';

			$r = Request::get($user_info_url);
			$this->about_dom = str_get_html($r);
		}
		return $this->about_dom;
	}

	/**
	 * 获取用户ID
	 * @return string 用户知乎ID
	 */
	public function get_name()
	{
		if ( ! empty($this->name)) {
			return $this->name;
		} else {
			$this->parser();
			$name = trim($this->dom->find('div.title-section span.name',0)->plaintext);
			$this->name = $name;
			return $name;
		}
	}


	/**
	 * 获取用户头像
	 * @return string 用户头像url
	 */
	public function get_avatar()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$this->parser();
			$avatar = $this->dom->find('div.zm-profile-header-avatar-container img', 0)->srcset;
			$avatar = str_replace("_xl", "", explode(' ', $avatar, 2)[0]);
			return $avatar;
		}
	}

	/**
	 * 获取用户居住地
	 * @return string 用户居住地
	 */
	public function get_location()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$location_link = $dom->find('div.item span.location', 0);
			if ( ! empty($location_link)) {
				$location = trim($location_link->plaintext);
				if ($location == '填写居住地 ') {
					$location = null;
				}
			} else {
				$location = null;
			}
			return $location;
		}
	}

	/**
	 * 获取用户所在行业
	 * @return string 所在行业
	 */
	public function get_business()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$business_link = $dom->find('div.item span.business', 0);
			if ( ! empty($business_link)) {
				$business = trim($business_link->plaintext);
				if ($business == '填写行业 ') {
					$business = null;
				}
			} else {
				$business = null;
			}
			return $business;
		}
	}


	/**
	 * 获取用户性别
	 * @return string 用户性别
	 */
	public function get_gender()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			if ( ! empty($dom->find('div.item span.gender', 0))) {
				$gender_link = $dom->find('div.item span.gender', 0);
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
	 * 获取用户公司信息
	 * @return string 用户公司信息
	 */
	public function get_employment()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$employment_link = $dom->find('div.item span.employment', 0);
			if ( ! empty($employment_link)) {
				$employment = trim($employment_link->plaintext);
				if ($employment == '填写公司信息 ') {
					$employment = null;
				}
			} else {
				$employment = null;
			}
			return $employment;
		}
	}

	/**
	 * 获取用户职位
	 * @return string 用户职位
	 */
	public function get_position()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$position_link = $dom->find('div.item span.position', 0);
			if ( ! empty($position_link)) {
				$position = trim($position_link->plaintext);
				if ($position == '填写职位 ') {
					$position = null;
				}
			} else {
				$position = null;
			}
			return $position;
		}
	}


	/**
	 * 获取用户学校信息
	 * @return string [获取用户学校信息]
	 */
	public function get_education()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$education_link = $dom->find('div.item span.education', 0);
			if ( ! empty($education_link)) {
				$education = trim($education_link->plaintext);
				if ($education == '填写学校信息 ') {
					$education = null;
				}
			} else {
				$education = null;
			}
			return $education;
		}
	}


	/**
	 * 获取用户专业
	 * @return string 用户专业
	 */
	public function get_major()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$major_link = $dom->find('div.item span.education-extra', 0);
			if ( ! empty($major_link)) {
				$major = trim($major_link->plaintext);
				if ($major == '填写专业 ') {
					$major = null;
				}
			} else {
				$major = null;
			}
			return $major;
		}
	}

	/**
	 * 获取用户个人简介
	 * @return string 用户个人简介
	 */
	public function get_description()
	{
		if (empty($this->url)) {
			return null;
		} else {
			$dom = $this->parser_about();
			$description_link = $dom->find('div.zm-profile-header-description span.description', 0);
			if ( ! empty($description_link)) {
				$description = trim($description_link->find('[class!=collapse]', 0)->innertext);
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
	 * 获取用户信息
	 * @return string 用户信息
	 */
	public function get_about()
	{
		$about = array(
			'name'	=>	$this->get_name(),
			'avatar'	=>	$this->get_avatar(),
			'location'	=>	$this->get_location(),
			'business'	=>	$this->get_business(),
			'gender'	=>	$this->get_gender(),
			'employment'=>	$this->get_employment(),
			'position'	=>	$this->get_position(),
			'education'	=>	$this->get_education(),
			'major'	=>	$this->get_major(),
			'description'	=>	$this->get_description()
		);
		return $about;
	}


	/**
	 * 获取用户关注数
	 * @return integer 关注人数
	 */
	public function get_followees_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_followers_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_agree_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_thanks_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_asks_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_answers_num()
	{
		if (empty($this->url)) {
			return -1;
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
	public function get_posts()
	{
		if (empty($this->url)) {
			return -1;
		} else {
			$this->parser();
			$posts_num = $this->dom->find('span.num', 2)->plaintext;
			return (int)$posts_num;
		}
	}

	/**
	 * 获取用户收藏数
	 * @return integer 收藏数
	 */
	public function get_collections_num()
	{
		if (empty($this->url)) {
			return -1;
		} else {
			$this->parser();
			$collections_num = $this->dom->find('span.num', 3)->plaintext;
			return (int)$collections_num;
		}
	}

	/**
	 * 获取用户关注话题数
	 * @return integer 用户关注话题数
	 */
	public function get_topics_num()
	{
		if (empty($this->url)) {
			return -1;
		} else {
			$this->parser();
			$topics_num = $this->dom->find('div.zm-profile-side-section strong', 1)->plaintext;
			$topics_num = explode(' ', $topics_num, 2)[0];
			return (int)$topics_num;
		}
	}


	/**
	 * 获取用户关注的话题列表
	 * @return Generator 话题迭代器
	 */
	public function get_topics()
	{
		$topics_num = $this->get_topics_num();
		if ($topics_num <= 0) {
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

						$topic_url = ZHIHU_URL.$topics_link->find('a', 1)->href;
						$topic_id = $topics_link->find('a', 1)->plaintext;
						yield new Topic($topic_url, $topic_id);
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

						$topic_url = ZHIHU_URL.$topics_link->find('a', 1)->href;
						$topic_id = $topics_link->find('a', 1)->plaintext;
						yield new Topic($topic_url, $topic_id);			
					}
				}
			}
		}
	}

	/**
	 * 获取用户关注列表
	 * @return Generator 关注列表
	 */
	public function get_followees()
	{
		return $this->get_follow('FOLLOWEES');
	}


	/**
	 * 获取用户粉丝列表
	 * @return Generator 粉丝列表
	 */
	public function get_followers()
	{
		return $this->get_follow('FOLLOWERS');
	}

	/**
	 * 获取用户列表
	 * @param  String $type 关注或者粉丝
	 * @return Generator  用户列表
	 */
	private function get_follow($type)
	{
		if ($type === 'FOLLOWERS') {
			$num = $this->get_followers_num();
			$url = $this->url.FOLLOWERS_SUFFIX_URL;
			$post_url = FOLLOWERS_LIST_URL;
		} elseif ($type === 'FOLLOWEES') {
			$num = $this->get_followees_num();
			$url = $this->url.FOLLOWEES_SUFFIX_URL;
			$post_url = FOLLOWEES_LIST_URL;
		} else {
			return null;
		}

		if ($num <= 0) {
			return null;
		} else {
			$r = Request::get($url);			
			$dom = str_get_html($r);

			$_xsrf = $dom->find('input[name=_xsrf]',0)->value;
		  	$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];
		  	
			for ($i = 0; $i < $num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($num, 20); $j++) { 
						$user_list = $dom->find('a.zg-link', $j);
						yield new User($user_list->href, $user_list->title);
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
						yield new User($user_list->href, $user_list->title);						
					}
				}
			}
		}
	}

	/**
	 * 获取用户提问列表
	 * @return Generator 提问列表迭代器
	 */
	public function get_asks()
	{
		if (empty($this->url)) {
			yield null;
		} else {
			$asks_num = $this->get_asks_num();

			if ($asks_num <= 0) {
				yield null;
			} else {
				for ($i = 0; $i < $asks_num /20; $i++) { 
					$ask_url = $this->url.ASKS_PAGE_SUFFIX_URL.($i+1);

					$r = Request::get($ask_url);
					$dom = str_get_html($r);

					for ($j = 0; $j < min($asks_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);
						
					 	$question_url = ZHIHU_URL.$question_link->href;
					 	$title = $question_link->plaintext;
					 	yield new Question($question_url, $title);
					} 
				}
			}
		}
	}

	/**
	 * 获取用户回答列表
	 * @return Generator 回答列表迭代器
	 */
	public function get_answers()
	{
		if (empty($this->url)) {
			yield null;
		} else {
			$answers_num = $this->get_answers_num();

			if ($answers_num <= 0) {
				yield null;
			} else {
				for ($i = 0; $i < $answers_num / 20; $i++) { 
					$answer_url = $this->url.ANSWERS_PAGE_SUFFIX_URL.($i+1);

					$r = Request::get($answer_url);
					$dom = str_get_html($r);

					for ($j = 0; $j < min($answers_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);

						$answer_url = ZHIHU_URL.$question_link->href;
						$question_url = ZHIHU_URL.substr($answer_url, 21, 18);
						$question_title = $question_link->plaintext;

						$question = new Question($question_url, $question_title);
						yield new Answer($answer_url, $question);
					}
				}
			}
		}
	}
}
