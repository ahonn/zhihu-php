<?php

/**
* 知乎专栏文章类
*/
class Post
{
    private $url;
    private $title;
    private $content;
    private $author;
    private $dom;

    function __construct($url, $title=null, $content=null, $author=null)
    {
        if (substr($url, 0, 25) !== COLUMN_PREFIX_URL) {
            throw new Exception($url.": it isn't a post url !");
        } else {
            $id = array(
                explode('/', $url)[3],
                explode('/', $url)[4]
            );

            $this->url = str_replace(array("{uid}", "{pid}"), $id, POST_URL);
            if ( ! empty($title)) {
                $this->title = $title;
            }
            if ( ! empty($content)) {
                $this->content = $content;
            }
            if ( ! empty($author)) {
                $this->author = $author;
            }
        }
    }

    public function parser()
    {
        if (empty($this->dom)) {
            $r = Request::get($this->url, $column=True);

            $this->dom = json_decode($r);
        }
    }

    public function url()
    {
        return $this->url;
    }

    public function title()
    {
        if (empty($this->title)) {
            $this->parser();
            $this->title = $this->dom->title;
        }
        return $this->title;
    }

    public function content()
    {
        if(empty($this->content)) {
            $this->parser();
            $this->content = $this->dom->content;
        }
        return $this->content;
    }

    public function author()
    {
        # code...
    }
}