<?php

require_once '../zhihu/zhihu.php';

class ColumnTest extends PHPUnit_Framework_TestCase
{
    private $url;
    private $column;

    function __construct()
    {
        $this->url = 'http://zhuanlan.zhihu.com/shaofeidu';
        $this->column = new Column($this->url);
    }

    public function testName()
    {
        $name = $this->column->name();
        $name_tmp = '杜少又来吹牛逼了';
        printf("%s \n", $name);

        $this->assertSame($name_tmp, $name);
    }

    public function testAuthor()
    {
        $author = $this->column->author();
        $this->assertInstanceOf('User', $author);

        printf("%s \n", $author->name());
        $name_tmp = '杜绍斐';
        $this->assertSame($name_tmp, $author->name());
    }

    public function testDesc()
    {
        $desc = $this->column->desc();
        printf("%s \n", $desc);

        $this->assertInternalType('string', $desc);
    }

    public function testFollower()
    {
        $followers_num = $this->column->followers_num();
        printf("%d \n", $followers_num);

        $this->assertInternalType('int', $followers_num);
    }

    public function testPost()
    {
        $posts_num = $this->column->posts_num();
        printf("%d \n", $posts_num);
        $this->assertInternalType('int', $posts_num);

        $posts = $this->column->posts();
        $count = 0;
        foreach ($posts as $post) {
            $count++;
            printf("%s \n", $post->title());
            $this->assertInstanceOf('Post', $post);
        }
        $this->assertLessThanOrEqual($posts_num, $count);
    }
}
