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

    /**
     * 解析文章主页
     * @return object simple html dom 对象
     */
    public function parser()
    {
        if (empty($this->dom)) {
            $r = Request::get($this->url, $column=True);

            $this->dom = json_decode($r);
        }
    }

    /**
     * 获取文章链接
     * @return string 文章 URL
     */
    public function url()
    {
        $this->parser();
        return COLUMN_PREFIX_URL.$this->dom->url;;
    }

    /**
     * 获取文章标题
     * @return string 文章标题
     */
    public function title()
    {
        if (empty($this->title)) {
            $this->parser();
            $this->title = $this->dom->title;
        }
        return $this->title;
    }

    /**
     * 获取文章内容
     * @return string 文章内容
     */
    public function content()
    {
        if(empty($this->content)) {
            $this->parser();
            $this->content = $this->dom->content;
        }
        return $this->content;
    }

    /**
     * 获取文章作者
     * @return User 文章作者
     */
    public function author()
    {
        if(empty($this->author)) {
            $this->parser();
            $author = $this->dom->author;
            $this->author = new User(USER_PREFIX_URL.$author->slug, $author->name);
        }
        return $this->author;
    }
}