<?php

class Time{
	private $starTime;
	private $stopTime;
	private function getMicTime(){
		$mictime=microtime();
		list($usec,$sec)=explode(' ',$mictime);
		return (float)$usec+(float)$sec;
	}
	
	public function star(){
		$this->starTime=$this->getMicTime();
	}
	
	public function stop(){
		$this->stopTime=$this->getMicTime();
	}
	
	public function spent(){
		return round($this->stopTime-$this->starTime)*1000;
	}
}