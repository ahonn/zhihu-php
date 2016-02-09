<?php

/**
* 知乎专栏类
*/
class Column
{
    private $id; 
    private $url;
    private $name;
    private $author;
    private $dom;

    function __construct($url, $name=null, $author=null)
    {
        if (substr($url, 0, 25) !== COLUMN_PREFIX_URL) {
            throw new Exception($url.": it isn't a column url !");
        } else {
            $this->id = substr($url, 26);
            $this->url = str_replace("{id}", $this->id, COLUMN_POSTS_URL);
            if( ! empty($name)) {
                $this->name = $name;
            }
            if( ! empty($author)) {
                $this->author = $author;
            }
        }
    }

    /**
     * 解析专栏主页
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
     * 获取 URL
     * @return string URL
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * 专栏名称
     * @return string 专栏名称
     */
    public function name()
    {
        if(empty($this->name)) {
            $this->parser();
            $this->name = $this->dom->name;
        }           
        return $this->name;
    }

    /**
     * 获取专栏作者
     * @return User 专栏作者
     */
    public function author()
    {
        if(empty($this->author)) {
            $this->parser();
            $author_url = USER_PREFIX_URL.$this->id;
            $this->author = new User($author_url);
        }
        return $this->author;
    }

    /**
     * 获取专栏描述
     * @return string 专栏描述
     */
    public function desc()
    {
        $this->parser();
        $desc = $this->dom->description;
        return $desc;
    }

    /**
     * 获取专栏关注数
     * @return int 关注数
     */
    public function followers_num()
    {
        $this->parser();
        $followers_num = (int)$this->dom->followersCount;
        return $followers_num;
    }

    /**
     * 获取专栏文章数
     * @return int 文章数
     */
    public function posts_num()
    {
        $this->parser();
        $posts_num = (int)$this->dom->postsCount;
        return $posts_num;
    }
    
    /**
     * 获取专栏文章
     * @return Generator 专栏文章
     */
    public function posts()
    {
        $url = $this->url.'/posts?limit=10&offset={offset}';

        $posts_num = $this->posts_num();
        for ($i = 0; $i < $posts_num / 10; $i++) { 
            $posts_url = str_replace('{offset}', $i * 10, $url);
            $r = Request::get($posts_url, $column=True);
            $posts = json_decode($r);
            
            foreach ($posts as $post) {
                $post_url = COLUMN_PREFIX_URL.$post->url;
                $post_title = $post->title;
                $post_content = $post->content;
                yield new Post($post_url, $post_title, $post_content);
            }
        }
    }
}