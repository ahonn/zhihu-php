<?php

class User 
{
	private $user_url;
	private $user_id;
	private $dom;

	function __construct($user_url, $user_id=null)
	{
		if (empty($user_url)) {
			$this->user_id = '匿名用户';
		} elseif (substr($user_url, 0, 29) !== USER_PREFIX_URL) {
			throw new Exception($user_url.": it isn't a user url !");
		} else {
			$this->user_url = $user_url;
			if ( ! empty($user_id)) {
				$this->user_id = $user_id;
			}
		}	
	}

	/**
	 * 解析用户主页
	 * @return [object] [simple html dom 对象]
	 */
	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->user_url);

			$this->dom = str_get_html($r);
		}
	}


	/**
	 * 解析用户about页
	 * @return [object] [simple html dom 对象]
	 */
	public function parser_about()
	{
		if (empty($this->about_dom)) {
			$user_info_url = $this->user_url.'/about';

			$r = Request::get($user_info_url);
			$this->about_dom = str_get_html($r);
		}
		return $this->about_dom;
	}


	/**
	 * 获取用户ID
	 * @return [string] [用户知乎ID]
	 */
	public function get_user_id()
	{
		if ( ! empty($this->user_id)) {
			return $this->user_id;
		} else {
			$this->parser();
			$user_id = $this->dom->find('div.title-section span.name',0)->plaintext;
			$this->user_id = $user_id;
			return $user_id;
		}
	}


	/**
	 * 获取用户头像
	 * @return [string] [用户头像url]
	 */
	public function get_avatar()
	{
		$this->parser();
		$avatar = $this->dom->find('div.zm-profile-header-avatar-container img', 0)->srcset;
		$avatar = str_replace("_xl", "", explode(' ', $avatar, 2)[0]);
		return $avatar;
	}

	/**
	 * 获取用户居住地
	 * @return [string] [用户居住地]
	 */
	public function get_location()
	{
		$dom = $this->parser_about();

		$location_link = $dom->find('div.item span.location', 0);
		if ( ! empty($location_link)) {
			$location = $location_link->plaintext;
			if ($location == '填写居住地 ') {
				$location = null;
			}
		} else {
			$location = null;
		}
		return $location;
	}

	/**
	 * 获取用户所在行业
	 * @return [string] [所在行业]
	 */
	public function get_business()
	{
		$dom = $this->parser_about();

		$business_link = $dom->find('div.item span.business', 0);
		if ( ! empty($business_link)) {
			$business = $business_link->plaintext;
			if ($business == '填写行业 ') {
				$business = null;
			}
		} else {
			$business = null;
		}
		return $business;
	}


	/**
	 * 获取用户性别
	 * @return [string] [用户性别]
	 */
	public function get_gender()
	{
		$dom = $this->parser_about();

		$gender_link = $dom->find('div.item span.gender', 0);
		if ( ! empty($gender_link->find('i.icon-profile-male'))) {
			$gender = 'male';
		} elseif ( ! empty($gender_link->find('i.icon-profile-female'))) {
			$gender = 'female';
		}		
		return $gender;
	}

	/**
	 * 获取用户公司信息
	 * @return [string] [用户公司信息]
	 */
	public function get_employment()
	{
		$dom = $this->parser_about();

		$employment_link = $dom->find('div.item span.employment', 0);
		if ( ! empty($employment_link)) {
			$employment = $employment_link->plaintext;
			if ($employment == '填写公司信息 ') {
				$employment = null;
			}
		} else {
			$employment = null;
		}
		return $employment;
	}

	/**
	 * 获取用户职位
	 * @return [string] [用户职位]
	 */
	public function get_position()
	{
		$dom = $this->parser_about();

		$position_link = $dom->find('div.item span.position', 0);
		if ( ! empty($position_link)) {
			$position = $position_link->plaintext;
			if ($position == '填写职位 ') {
				$position = null;
			}
		} else {
			$position = null;
		}
		return $position;
	}


	/**
	 * 获取用户学校信息
	 * @return [string] [获取用户学校信息]
	 */
	public function get_education()
	{
		$dom = $this->parser_about();

		$education_link = $dom->find('div.item span.education', 0);
		if ( ! empty($education_link)) {
			$education = $education_link->plaintext;
			if ($education == '填写学校信息 ') {
				$education = null;
			}
		} else {
			$education = null;
		}
		return $education;
	}


	/**
	 * 获取用户专业
	 * @return [string] [用户专业]
	 */
	public function get_major()
	{
		$dom = $this->parser_about();

		$major_link = $dom->find('div.item span.education-extra', 0);
		if ( ! empty($major_link)) {
			$major = $major_link->plaintext;
			if ($major == '填写专业 ') {
				$major = null;
			}
		} else {
			$major = null;
		}
		return $major;
	}

	/**
	 * 获取用户个人简介
	 * @return [string] [用户个人简介]
	 */
	public function get_description()
	{
		$dom = $this->parser_about();

		$description_link = $dom->find('div.zm-profile-header-description span.description', 0);
		if ( ! empty($description_link)) {
			$description = $description_link->find('[class!=collapse]', 0)->innertext;
			if ($description == '    ') {
				$description = null;
			}
		} else {
			$description = null;
		}
		return $description;
	}


	/**
	 * 获取用户信息
	 * @return [string] [用户信息]
	 */
	public function get_about()
	{
		$about = array(
			'user_id'	=>	$this->get_user_id(),
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
	 * @return [int] [关注人数]
	 */
	public function get_followees_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$followees_num = (int)$this->dom->find('div.zm-profile-side-following strong', 0)->plaintext;
			return $followees_num;
		}	
	}

	/**
	 * 获取用户粉丝数
	 * @return [int] [粉丝人数]
	 */
	public function get_followers_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$followers_num = (int)$this->dom->find('div.zm-profile-side-following strong', 1)->plaintext;
			return $followers_num;
		}
	}

	/**
	 * 获取用户赞同数
	 * @return [int] [赞同数]
	 */
	public function get_agree_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$agree_num = (int)$this->dom->find('div.zm-profile-header-info-list strong', 0)->plaintext;
			return $agree_num;
		}
	}


	/**
	 * 获取用户感谢数
	 * @return [int] [感谢数]
	 */
	public function get_thanks_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$thanks_num = (int)$this->dom->find('div.zm-profile-header-info-list strong', 1)->plaintext;
			return $thanks_num;
		}
	}

	/**
	 * 获取用户提问数
	 * @return [int] [提问数]
	 */
	public function get_asks_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$asks_num = (int)$this->dom->find('span.num', 0)->plaintext;
			return $asks_num;
		}
	}

	/**
	 * 获取用户回答数
	 * @return [int] [回答数]
	 */
	public function get_answers_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$answers_num = (int)$this->dom->find('span.num', 1)->plaintext;
			return $answers_num;
		}
	}

	/**
	 * 获取用户收藏数
	 * @return [int] [收藏数]
	 */
	public function get_collections_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$collections_num = (int)$this->dom->find('span.num', 3)->plaintext;
			return $collections_num;
		}
	}

	/**
	 * 获取用户关注话题数
	 * @return [int] [用户关注话题数]
	 */
	public function get_topics_num()
	{
		if (empty($this->user_url)) {
			return -1;
		} else {
			$this->parser();
			$topics_num = $this->dom->find('div.zm-profile-side-section strong', 1)->plaintext;
			$topics_num = (int)explode(' ', $topics_num, 2)[0];
			return $topics_num;
		}
	}


	/**
	 * 获取用户关注的话题列表
	 * @return [array] [话题列表]
	 */
	public function get_topics()
	{
		$topics_num = $this->get_topics_num();
		if ($topics_num == 0) {
			return;
		} else {
			$topics_url = $this->user_url.TOPICS_PREFIX_URL;
			$r = Request::get($topics_url);
			$dom = str_get_html($r);

			$_xsrf = $dom->find('input[name=_xsrf]', 0)->attr['value'];
			for ($i = 0; $i < $topics_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($topics_num, 20); $j++) { 
						$topics_link =  $dom->find('div.zm-profile-section-main', $j);

						$topic_url = ZHIHU_URL.$topics_link->find('a', 1)->href;
						$topic_id = $topics_link->find('a strong', 0)->plaintext;
						$topics_list[] = new Topic($topic_url, $topic_id);
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
						$topic_id = $topics_link->find('a strong', 0)->plaintext;
						$topics_list[] = new Topic($topic_url, $topic_id);			
					}
				}
			}
			return $topics_list;
		}
	}

	/**
	 * 获取用户关注列表
	 * @return [array] [关注列表]
	 */
	public function get_followees()
	{
		$followees_num = $this->get_followees_num();
		if ($followees_num == 0) {
			return;
		} else {
			$followee_url = $this->user_url.FOLLOWEES_SUFFIX_URL;
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
				} else {
					$post_url = FOLLOWEES_LIST_URL;
			
					$params = json_decode(html_entity_decode($json))->params;
					$params->offset = $i * 20;
					$params = json_encode($params);

					$data = array(
						'_xsrf' => $_xsrf,
						'method' => 'next',
						'params' => $params
					);

					$r = Request::post($post_url, $data, array("Referer: {$followee_url}"));
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
	 * 获取用户粉丝列表
	 * @return [array] [粉丝列表]
	 */
	public function get_followers()
	{
		$followers_num = $this->get_followers_num();
		if ($followers_num == 0) {
			return;
		} else {
			$follower_url = $this->user_url.FOLLOWERS_SUFFIX_URL;
			$r = Request::get($follower_url);
			
			$dom = str_get_html($r);

			$post_url = FOLLOWERS_LIST_URL;
			$_xsrf = $dom->find('input[name=_xsrf]',0)->value;
		  	$json = $dom->find('div.zh-general-list', 0)->attr['data-init'];
		  	
			for ($i = 0; $i < $followers_num / 20; $i++) { 
				if ($i == 0) {
					for ($j = 0; $j < min($followers_num, 20); $j++) { 
						$user_list[$j] = $dom->find('a.zg-link', $j);
						$followers_list[] = new User($user_list[$j]->href, $user_list[$j]->title);
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
	 * 获取用户提问列表
	 * @return [object array] [提问列表]
	 */
	public function get_asks()
	{
		if (empty($this->user_url)) {
			return null;
		} else {
			$asks_num = $this->get_asks_num();

			if ($asks_num == 0) {
				return null;
			} else {
				for ($i = 0; $i < $asks_num /20; $i++) { 
					$ask_url = $this->user_url.ASKS_SUFFIX_URL.($i+1);

					$r = Request::get($ask_url);
					$dom = str_get_html($r);

					for ($j = 0; $j < min($asks_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);
						
					 	$question_url = ZHIHU_URL.$question_link->href;
					 	$title = $question_link->plaintext;
					 	$asks[] = new Question($question_url, $title);
					} 
				}
				return $asks;
			}
		}
	}

	/**
	 * 获取用户回答列表
	 * @return [object array] [回答列表]
	 */
	public function get_answers()
	{
		if (empty($this->user_url)) {
			return null;
		} else {
			$answers_num = $this->get_answers_num();

			if ($answers_num == 0) {
				return null;
			} else {
				for ($i = 0; $i < $answers_num / 20; $i++) { 
					$answer_url = $this->user_url.ANSWERS_SUFFIX_URL.($i+1);

					$r = Request::get($answer_url);
					$dom = str_get_html($r);
					
					for ($j = 0; $j < min($answers_num - $i * 20, 20); $j++) { 
						$question_link = $dom->find('a.question_link', $j);

						$answer_url = $question_link->href;
						$question_url = ZHIHU_URL.substr($answer_url, 0, 18);
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

