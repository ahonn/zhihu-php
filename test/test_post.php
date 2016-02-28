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

    public function testUrl()
    {
        $url = $this->post->url();
        printf("%s \n", $url);
        $this->assertSame($this->url, $url);
    }

    public function testTitle()
    {
        $title = $this->post->title();
        printf("%s \n", $title);
        $title_tmp = '人生苦短，我用 Mac';

        $this->assertSame($title_tmp, $title);
    }

    public function testContent()
    {
        $content = $this->post->content();
        printf("%s \n", $content);

        $this->assertInternalType('string', $content);
    }

    public function testAuthor()
    {
        $author = $this->post->author();
        printf("%s \n", $author->name());
        $this->assertInstanceOf('User', $author);
    }
}
