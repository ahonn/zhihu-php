<?php

class Collection
{
	private $collection_url;
	private $collection_title;
	private $dom;

	function __construct($collection_url, $collection_title=null)
	{
		if (substr($collection_url, 0, 33) !== COLLECTION_PREFIX_URL) {
			throw new Exception($collection_url.": it isn't a collection url !");
		} else {
			$this->collection_url = $collection_url;
			if ( ! empty($collection_title)) {
				$this->collection_title = $collection_title;
			}
		}	
	}
	
	public function parser()
	{
		if (empty($this->dom)) {
			$r = Request::get($this->collection_url);
			$this->dom = str_get_html($r);
		}
	}

	public function get_title()
	{
		if( ! empty($this->title)) {
			$title = $this->title;
		} else {
			$this->parser();
			$title = trim($this->dom->find('div#zh-list-title', 0)->plaintext);
		}
		return $title;
	}

	public function get_description()
	{
		$this->parser();
		$description = $this->dom->find('div#zh-fav-head-description', 0)->plaintext;
		return $description;
	}

	public function get_author()
	{
		$this->parser();
		$author_link = $this->dom->find('h2.zm-list-content-title a', 0);
		$author_url = ZHIHU_URL.$author_link->href;
		$author_id = $author_link->plaintext;
		return new User($author_url, $author_id);
	}
}