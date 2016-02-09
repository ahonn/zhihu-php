<?php

require_once '../zhihu/zhihu.php';

class PostTest extends PHPUnit_Framework_TestCase
{
    private $url;
    private $post;
    
    function __construct()
    {
        $this->url = 'http://zhuanlan.zhihu.com/mactalk/20278296';
        $this->post = new Post($this->url);
    }

    public function testTitle()
    {
        $title = $this->post->title();
        $title_tmp = '人生苦短，我用 Mac';

        $this->assertSame($title_tmp, $title);
    }

    public function testContent()
    {
        $content = $this->post->content();

        $this->assertInternalType('string', $content);
    }
}