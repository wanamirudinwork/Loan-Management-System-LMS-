<?php
class currencyToWords{
	var $words = array();
	var $places = array();
	var $amount_in_words;
	var $decimal;
	var $decimal_len;
	
	public function __construct($amount) {
		$this->assign();
		
		//Separate Amount and Cents
		$temp = (string) $amount;
		$pos = strpos($temp, ".");
		if ($pos) {
			$temp = substr($temp, 0, $pos);
			$this->decimal = strstr((string) $amount, ".");
			$this->decimal_len = strlen($this->decimal) - 2;
			$this->decimal = substr($this->decimal, 1, $this->decimal_len + 1);
		}
		
		$len = strlen($temp) - 1;
		$ctr = 0;
		$arr = array();
		while ($len >= 0) {
			if ($len >= 2) {
				$arr[$ctr++] = substr($temp, $len - 2, 3);
				$len -= 3;
			} else {
				$arr[$ctr++] = substr($temp, 0, $len + 1);
				$len = -1;
			}
		}
		
		//Convert Amount to Words
		$str = "";
		for ($i = count($arr) - 1; $i >= 0; $i--) {
			$figure = $arr[$i];
			$sub = array(); 
			$temp="";
			for ($y = 0; $y < strlen(trim($figure)); $y++) {
				$sub[$y] = substr($figure, $y, 1);
			}
			$len = count($sub);
			if ($len == 3) {
				if ($sub[0] != "0") {
					$temp .= ((strlen($str) > 0) ? " " : "") . trim($this->words[$sub[0]]) . " Hundred";
				}
				$temp .= $this->processTen($sub[1], $sub[2]);
			} elseif ($len ==2) {
				$temp .= $this->processTen($sub[0], $sub[1]);
			} else {
				$temp .= $words[$sub[0]];
			}
			if (strlen($temp) > 0) {
				$str .= $temp . $this->places[$i];
			}
		}
		
		//Convert Cent to Words
		//$str .= " ";
		if ($this->decimal_len > 0) {
			$sub = array();
			for ($y = 0; $y < strlen(trim($this->decimal)); $y++) {
				$sub[$y] = substr($this->decimal, $y, 1);
			}
			$str .= " and".$this->processTen($sub[0], $sub[1])." Cent only";
		}
		$this->amount_in_words = $str;
	}
	
	public function convert() {
		return $this->amount_in_words;
	}


	private function denominator($x) {
		$temp = "1";
		for ($i=1; $i<=$x; $i++) {
			$temp .= "0";
		}
		return $temp;
	}
	

	private function processTen($sub1, $sub2) {
		if ($sub1 == "0") {
			if ($sub2 == "0") {
				return "";
			} else {
				return $this->words[$sub2];
			}
		} elseif ($sub1 != "1") {
			if ($sub2 != "0") {
				return $this->words[$sub1."0"] . $this->words[$sub2];
			} else {
				return $this->words[$sub1 . $sub2];
			}
		} else {
			if ($sub2 == "0") {
				return $this->words["10"];
			} else {
				return $this->words[$sub1 . $sub2];
			}
		}
	}

	public function assign() {
		$this->words["1"] = " One"; 			
		$this->words["2"] = " Two";
		$this->words["3"] = " Three"; 		
		$this->words["4"] = " Four";
		$this->words["5"] = " Five"; 			
		$this->words["6"] = " Six";
		$this->words["7"] = " Seven";			
		$this->words["8"] = " Eight";
		$this->words["9"] = " Nine";
	
		$this->words["10"] = " Ten";			
		$this->words["11"] = " Eleven";
		$this->words["12"] = " Twelve";		
		$this->words["13"] = " Thirten";
		$this->words["14"] = " Fourten";		
		$this->words["15"] = " Fiften";
		$this->words["16"] = " Sixten";		
		$this->words["17"] = " Seventen";
		$this->words["18"] = " Eighten";		
		$this->words["19"] = " Nineten";

		$this->words["20"] = " Twenty";		
		$this->words["30"] = " Thirty";
		$this->words["40"] = " Forty";		
		$this->words["50"] = " Fifty";
		$this->words["60"] = " Sixty";		
		$this->words["70"] = " Seventy";
		$this->words["80"] = " Eighty";		
		$this->words["90"] = " Ninety";
	
		$this->places[0] = "";				
		$this->places[1] = " Thousand";
		$this->places[2] = " Million";		
		$this->places[3] = " Billion";
		$this->places[4] = " Thrillion";
	}
}