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
		
		//$paging = $paging."<li><a href='&page=1'>처음</a></li>";

		if($block > 1){
			$is_page = $first_page;
			$paging = $paging."<li><a href='#Prev' onclick='return false;'><input type='hidden' name='page' value='".$is_page."' />&laquo;</a></li>";
		} else {
			$paging = $paging."<li><a href='#Prev' onclick='return false;'>&laquo;</a></li>";
		}
		
		/*
		if($last_page >= $this -> page && $this -> page != 1) {
			$paging = $paging."<a href='$isfile?parent_menu_code=".$tempMap['PARENT_MENU_CODE']."&menu_code=".$tempMap['MENU_CODE']."&page=".($this -> page-1)."'><</a> ";
		} else {
			$paging = $paging."< ";
		}
		*/

		for($link_page = $first_page+1; $link_page<=$last_page; $link_page++){
			if($this -> page == $link_page){
				$paging = $paging."<li class='selected'><a href='#".$link_page."' onclick='return false;'><strong>".$link_page."</strong></a></li>";
			} else {
				$paging = $paging."<li><a href='#".$link_page."' onclick='return false;'><input type='hidden' name='page' value='".$link_page."' />".$link_page."</a></li>";
			}
		}
		
		/*
		if($this -> page < $this -> total_page) {
			$paging = $paging."<a href='$isfile?parent_menu_code=".$tempMap['PARENT_MENU_CODE']."&menu_code=".$tempMap['MENU_CODE']."&page=".($this -> page+1)."'>></a> ";
		} else {
			$paging = $paging."> ";
		}
		*/
		
		if($block < $total_block){
			$is_page = $last_page+1;
			$paging = $paging."<li><a href='#Prev' onclick='return false;'><input type='hidden' name='page' value='".$is_page."' />&raquo;</a></li>";
		} else {
			$paging = $paging."<li><a href='#Next' onclick='return false;'>&raquo;</a></li>";
		}
		
		//$paging = $paging."<li><a href='&page=".$this -> total_page."'>맨뒤</a></li>";
		
		if($this -> total_page == 0) $paging = "";

		$this -> paging = $paging;
	}

	public function getResult() {

		$tempMap['paging']		= $this -> paging;
		$tempMap['total_page']	= $this -> total_page;
		$tempMap['first']		= $this -> first;
		$tempMap['last']		= $this -> last;
		$tempMap['num']			= $this -> num;

		return $tempMap;
	}
}