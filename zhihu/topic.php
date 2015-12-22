<?php

class Topic 
{
	private $topics_url;
	private $topics_id;
	private $dom;

	function __construct($topics_url, $topics_id=null)
	{
		if (substr($topics_url, 0, 28) != TOPICS_PREFIX_URL) {
			throw new Exception($topics_url.": it isn't a topics url !");
		} else {
			$this->topics_url = $topics_url;
			if ( ! empty($topics_id)) {
				$this->topics_id = $topics_id;
			}
		}
	}

	/**
	 * 解析话题主页
	 * @return [object] [simple html dom 对象]
	 */
	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->topics_url);

			$this->dom = str_get_html($r);
		}
	}

	/**
	 * 获取话题描述
	 * @return [string] [话题描述]
	 */
	public function get_description()
	{
		$this->parser();
		$description = $this->dom->find('div#zh-topic-desc div.zm-editable-content', 0)->plaintext;
		return $description;
	}
}