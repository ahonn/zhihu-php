<?php

/**
 * cURL 封装类 Request
 */
date_default_timezone_set('PRC');

class Request
{
	private static $cookie = COOKIE;

	private static $header = array(
		"Host: www.zhihu.com",
        "Accept-Encoding:gzip, deflate, sdch",
        "Accept: text/html, application/xhtml+xml, image/jxr, */*",
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586"
	);

	/**
	 * 发送 get 请求
	 * @param  string $url    请求url
	 * @param  array  $header 头信息
	 * @return string         返回数据
	 */
	public static function get($url, $column=False,  $header=array())
	{
		$header = array_merge(self::$header, $header);

		if ($column) {
			$header[0] = "Host: zhuanlan.zhihu.com";
			$header[2] = "Accept:application/json, text/plain, */*";
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
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
	 * 发送 post 请求
	 * @param  string $url    请求url
	 * @param  array  $data   post 数据
	 * @param  array  $header 头信息
	 * @return string         返回数据
	 */
	public static function post($url, array $data, $header=array())
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