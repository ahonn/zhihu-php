<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-29 20:02:00
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2016-01-03 15:49:15
 */

/**
 * 下载用户关注的粉丝数超过 1000 的妹子头像
 */
require_once 'zhihu-php/zhihu.php';

$user_url = 'https://www.zhihu.com/people/excited-vczh';
$user = new User($user_url);

$user_id = $user->get_user_id();
$followers_list = $user->get_followees();

$path = dirname(__FILE__).'/'.$user_id.'/';

if ( ! file_exists($path)) {
	mkdir($path);
}

foreach ($followers_list as $followers) {
	$gender = $followers->get_gender();
	$followers_num = $followers->get_followers_num();

	if ($gender == 'female' && $followers_num >= 1000) {
		$photo_name = $followers->get_user_id();
		$photo_url = $followers->get_avatar();
		

		$photo_name = iconv("UTF-8//TRANSLIT","gbk//TRANSLIT", $photo_name);
		$filename = $photo_name.'_'.$followers_num.'.jpg';

		file_put_contents($path.$filename, file_get_contents($photo_url));
		echo $filename." Finish!!\n";
	}
}