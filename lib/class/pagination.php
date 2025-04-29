<?php
class pagination{
	var $data;
	var $limit;
	var $page;
	var $path;
	var $totalRecord;
	var $currentPage;
	var $totalPage;
	var $startValue;
	var $pageData;
	
	public function __construct($data, $limit, $page, $path = ''){
		$this->data = $data;
		$this->limit = $limit;
		$this->page = $page;
		$this->totalRecord = $this->getTotalData();
		$this->totalPage = $this->getTotalPage();
		$this->startValue = $this->getStartData();
		$this->path = $path;
	}
	
	private function getTotalData(){
		return count($this->data);
	}
	
	private function getTotalPage(){
		$pages  = intval($this->totalRecord / $this->limit);
        if($this->totalRecord % $this->limit > 0){
			$pages++;
		}
        return $pages;
	}
	
	private function getStartData(){
		if(empty($this->page)){
			$this->page = 1;
		}
		
		if(isset($this->page) && $this->page > 0){
			$this->currentPage = $this->page;
			if($this->currentPage > $this->totalPage){
				$this->currentPage = 1;
			}
			$start = ($this->currentPage * $this->limit) - $this->limit;
		}else if($this->page > $this->totalPage){
			$start = $this->totalPage;
		}else{
			$start= 0;
		}
		
		return $start;
	}
	
	public function result(){
		for($i = $this->startValue; $i < ($this->startValue + $this->limit); $i++){
			if(!empty($this->data[$i])){
				$this->pageData[] = $this->data[$i];
			}
		}
		return $this->pageData;
	}
	
	public function display(){
		if($this->currentPage <= 0){
			$next = 2;
		}else{
			$next = $this->currentPage + 1;
		}
		
		$html = '';
		
		$prev = $this->currentPage - 1;
		$last = $this->totalPage;
		
		if($this->currentPage > 1){
			//$html .= '<li><a href="'.$this->path.'/1" title="First"><i class="fa fa-angle-double-left"></i></a></li>';
			$html .= '<li><a href="'.$this->path.'/'.$prev.'" title="Prev">Prev</a></li>';
		}else{
			//$html .= '<li class="disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>';
			$html .= '<li class="disabled"><a href="#">Prev</a></li>';
		}
		
		if($this->totalPage > 0){
			for($i = 1; $i <= $this->totalPage; $i++){
				if($i == $this->currentPage){
					$html .= '<li class="disabled"><a href="#">' . $i . '</a></li>';
				}else{
					
					$html .= '<li><a href="'.$this->path.'/'.$i.'"> '.$i.' </a></li>';
				}
			}
		}else{
			$html .= '<li class="disabled"><a href="#">1</a></li>';
		}

        if($this->currentPage < $this->totalPage){
			$html .= '<li><a href="'.$this->path.'/'.$next.'" title="Next">Next</a></li>';
			//$html .= '<li><a href="'.$this->path.'/'.$last.'" title="Last"><i class="fa fa-angle-double-right"></i></a></li>';
		}else{
			$html .= '<li class="disabled"><a href="#">Next</a></li>';
			//$html .= '<li class="disabled"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>';
		}
		
		return $html;
    } 
}
?>