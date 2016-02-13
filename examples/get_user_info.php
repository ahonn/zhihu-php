<?php

require_once '../zhihu/zhihu.php';

$url = 'https://www.zhihu.com/people/excited-vczh';
$user = new User($url);

printf("用户名: %s \n", $user->name());
printf("用户介绍: %s \n", $user->desc());
printf("用户关注人数: %d \n", $user->followees_num());
printf("用户分数人数: %d \n", $user->followers_num());
printf("用户获得赞同数: %d \n", $user->agree_num());
printf("用户获得感谢数: %d \n", $user->thanks_num());

printf("用户专栏列表: \n");
foreach ($user->columns() as $column) {
    printf("%s \n", $column->name());
}
printf("用户专栏文章数: %d , 文章名称列表: \n", $user->posts_num());
foreach ($user->posts() as $post) {
    printf("%s \n", $post->title());
}
