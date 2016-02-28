<?php

require_once '../zhihu/zhihu.php';

class CollectionTest extends PHPUnit_Framework_TestCase
{

    function __construct()
    {
        $this->url = 'https://www.zhihu.com/collection/19650606';
        $this->collection = new Collection($this->url);
    }

    public function testTitle()
    {
        $title = $this->collection->title();
        $title_tmp = '妙趣横生';
        printf("%s \n", $title);

        $this->assertSame($title_tmp, $title);
    }

    public function testDesc()
    {
        $desc = $this->collection->desc();
        $desc_tmp = '嬉笑怒骂，剑走偏锋，思路切入显大巧，文字构筑含义深。';
        printf("%s \n", $desc);

        $this->assertSame($desc_tmp, $desc);
    }

    public function testAuthor()
    {
        $author = $this->collection->author();
        $this->assertInstanceOf('User', $author);

        $author_name = '杨凯光';
        printf("%s \n", $author->name());
        $this->assertSame($author_name, $author->name());
    }


    public function testAnswer()
    {
        $answers = $this->collection->answers();
        for($i = 0; $i < 200; $i++) {
            $answer = $answers->current();
            $answers->next();
            $this->assertInstanceOf('Answer', $answer);
            printf("%s \n", $answer->question()->title());
        }
    }
}
