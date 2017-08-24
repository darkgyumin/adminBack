<?php
class PagingUtil {
	private static $instance = null;
	private function __construct() {}
	private function __clone() {}

	public static function getInstance() {
		
		if(!is_object(self::$instance)) {
			self::$instance = new PagingUtil();		
		}
		
		return self::$instance;
	}

	var $page;
	var $total_record;
	var $total_page;
	var $first;
	var $last;
	var $first_page = '';
	var $last_page = '';
	var $paging;
	var $num;

	public function setPaging($tempMap) {
		$paging = "";

		$this -> total_record = $tempMap['total_record'];
		$this -> page = $tempMap['page'];

		if(!$this -> page){$this -> page = 1;}

		if(!$this -> total_record){
			$this -> first = 1;
			$this -> last = 0;
		} else {
			$this -> first	= $tempMap['listNum'] * ($this -> page-1);
			$this -> last	= $tempMap['listNum'] * $this -> page;
			$IsNext = $this -> total_record - $this -> last;

			if($IsNext > 0) {
				$this -> last -= 1;
			} else {
				$this -> last = $this -> total_record - 1;
			}
		}
		$this -> total_page = ceil($this -> total_record / $tempMap['listNum']);

		$total_block = ceil($this -> total_page / $tempMap['blockNum']);
		$block = ceil($this -> page /$tempMap['blockNum']);
		$first_page = ($block-1) * $tempMap['blockNum'];
		$last_page = $block * $tempMap['blockNum'];

		$this -> num = $this -> total_record-$tempMap['listNum']*($this -> page-1);

		
		if($block >= $total_block){
			$last_page=$this -> total_page;
		}

		if($block > 1){
			$this -> first_page = $is_page = $first_page;
		} else {}

		for($link_page = $first_page+1; $link_page<=$last_page; $link_page++){
			$paging .= $link_page;
			if($link_page != $last_page) $paging .= ' ';
		}
		
		if($block < $total_block){
			$this -> last_page = $is_page = $last_page+1;
		} else {}
		
		if($this -> total_page == 0) $paging = "";

		$this -> paging = $paging;
	}

	public function getResult() {

		$tempMap['paging']		= $this -> paging;
		$tempMap['total_page']	= $this -> total_page;
		$tempMap['first_page']	= $this -> first_page;
		$tempMap['last_page']	= $this -> last_page;
		$tempMap['num']			= $this -> num;

		return $tempMap;
	}
}