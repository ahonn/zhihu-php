<?php
/**
 * @Author: Ahonn
 * @Date:   2015-12-15 09:04:11
 * @Last Modified by:   Ahonn
 * @Last Modified time: 2015-12-15 19:07:08
 */

date_default_timezone_set('PRC');

class Request
{
	private static $cookie = '_za=49121d34-f954-4c03-8312-70f297be0719; _xsrf=58f669c38860b22821aea272667b6ffb; q_c1=2fbe4135ed0c424c988683146db619de|1448352668000|1448352668000; cap_id=MjkzNTE5OTQxMzdhNDBiNjg5MmMyMzI3MjM3ZjY4OTc=|1450168234|ab23cb949c6a6cdc28a4a1e761f5755113a89cf5; __utma=51854390.853340688.1448352673.1450157361.1450168244.4; __utmz=51854390.1448352673.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=51854390.100-1|2=registration_date=20140722=1^3=entry_date=20140722=1; __utmb=51854390.6.10.1450168244; __utmc=51854390; __utmt=1; z_c0=QUFCQW4zZ3pBQUFYQUFBQVlRSlZUYzFjbDFid2ZvLWR3YThIOVk0WGxEanpTM1NlX0s0eHF3PT0=|1450168269|a83f56bbd949c807be2d70daf9700cfe60fb5079; unlock_ticket=QUFCQW4zZ3pBQUFYQUFBQVlRSlZUZFhXYjFZVFdiQ3JfdXhyMWtZTjZTSWF6Sl9tcmpfdlpBPT0=|1450168269|7d4db11aa94e5f109075f9c02bfd95fffd0b58d9';
	
	private static $header = array(
		"Host: www.zhihu.com",
        "Connection: Keep-Alive",
        "Accept-Encoding:gzip, deflate, sdch",
        "Accept: text/html, application/xhtml+xml, image/jxr, */*",
        "User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36"
	);

	/**
	 * get 方法请求
	 * @param  [string] $url [请求url]
	 * @return [string]      [请求内容]
	 */
	public static function get($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header);
		curl_setopt($ch, CURLOPT_COOKIE, self::$cookie);
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($ch);

		curl_close($ch);
		return $result;
	}


	/**
	 * post 方法请求
	 * @param  [string] $url  [请求url]
	 * @param  array  $data [post数据]
	 * @return [string]       [请求内容]
	 */
	public static function post($url, $data = array(), $header = array())
	{
		$header = array_merge(self::$header, $header);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_COOKIE, self::$cookie);
		curl_setopt($ch, CURLOPT_ENCODING ,'gzip');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);

		curl_close($ch);
		return $result;
	}
}