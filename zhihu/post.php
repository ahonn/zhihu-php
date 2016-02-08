<?php

/**
* 知乎专栏文章类
*/
class Post
{
    private $url;
    private $title;
    private $content;

    function __construct($url, $title=null, $content=null)
    {
        if (substr($url, 0, 26) !== COLUMN_PREFIX_URL) {
            throw new Exception($url.": it isn't a post url !");
        } else {
            $this->url = $url;
            if ( ! empty($title)) {
                $this->title = $title;
            }
            if ( ! empty($content)) {
                $this->content = $content;
            }
        }
    }
}