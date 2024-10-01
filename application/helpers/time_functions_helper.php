<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Time functions
	//integer == seconds
	function days_to_seconds($days){
		return ($days * 24 * 60 * 60) ;
		}
	function hours_to_seconds($hours){
		return ($hours * 60 * 60) ;
		}
	function integer_to_timestamp($integer_time){
		return date('Y-m-d H:i:s',$integer_time) ;
		}
	function timestamp_to_integer($timestamp){
		return strtotime($timestamp) ;
		}
	function microtime_float(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec);
	}	
	function getdateinfo($timestamp){
		//Function to return date and time in the format below
		$time = date('M, d Y',strtotime($timestamp) );	//Y=year M='month:Jan' n=month	D='day:Tue'	d='day:2' G=hrs:04 i=min:23	s=sec:18
		return $time;
		}
	function getfulldateinfo($timestamp){
		//Function to return date and time in the format below
		$time = date('D, jS M, Y. g:ia',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getfulldateinfo_Type1($timestamp){
		//Function to return date and time in the format below
		$time = date('D, M j, Y. g:ia',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getdateinfo_newstype1($timestamp){
		//Function to return date and time in the format below
		$time = date('j/m g:i a',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getdateinfo_newstype2($timestamp){
		//Function to return date and time in the format below
		$time = date('F j, Y',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getdateinfo_newstype3($timestamp){
		//Function to return date and time in the format below
		$time = date('M j, Y',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getdateinfo_newstype4($timestamp){
		//Function to return date and time in the format below
		$time = date('j/m, Y g:i a',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getDayInfo_Type1($timestamp){
		//Function to return date and time in the format below
		$time = date('M j, Y',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getTimeInfo_Type1($timestamp){
		//Function to return date and time in the format below
		$time = date('g:iA',strtotime($timestamp) );//D=Fri j=6 S='th/nd' F=Oct	Y=2011	 g(12hrsclock)=6 i(min)=23 a=pm/am
		return $time;
		}
	function getcurrtimeinfo(){
		//Function to return current date and time in integer format
		$time = time() ;
		return $time;
		}
	function timegone($seconds){
		$seconds2 = $seconds ; //$seconds2 = $seconds - 3599 ; 
		//The modification commented above was due to an error of 3600 seconds in my system's time
		if($seconds2 > (3600*24*7*4*12)){
			$sum = (integer)($seconds2 / (3600*24*7*4*12)) ;
			if($sum == 1){$ans = "a year ago";					}else{
			$ans = "$sum years ago" ;	}//end inner else
		}else if($seconds2 > (3600*24*7*4)){
			$sum = (integer)($seconds2 / (3600*24*7*4)) ;
			if($sum == 1){$ans = "last month";					}else{
			$ans = "$sum months ago" ;	}//end inner else
		}else if($seconds2 > (3600*24*7)){
			$sum = (integer)($seconds2 / (3600*24*7)) ;
			if($sum == 1){$ans = "last week";					}else{
			$ans = "$sum weeks ago" ;	}//end inner else
		}else if($seconds2 > (3600*24)){
			$sum = (integer)($seconds2 / (3600*24)) ;
			if($sum == 1){$ans = "yesterday";					}else{
			$ans = "$sum days ago" ;	}//end inner else
		}else if($seconds2 > 3600){
			$sum = (integer)($seconds2 / 3600) ;
			if($sum == 1){$ans = "an hour ago";					}else{
			$ans = "$sum hours ago" ;	}//end inner else
		}else if($seconds2 > 60){
			$sum = (integer)($seconds2 / 60) ;
			if($sum == 1){$ans = "a min ago";				}else{
			$ans = "$sum mins ago" ;	}//end inner else
		}else{
			if($seconds2 == 1){$ans = "now";	}else{
			$ans = "now" ; }//end inner else
			}
		return $ans ;
		}
	function tinyTimegone($seconds){
		$seconds2 = $seconds ; //$seconds2 = $seconds - 3599 ; 
		//The modification commented above was due to an error of 3600 seconds in my system's time
		if($seconds2 > (3600*24*7*4*12)){
			$sum = (integer)($seconds2 / (3600*24*7*4*12)) ;
			if($sum == 1){$ans = "1Yr";					}else{
			$ans = "$sum"."Yrs" ;	}//end inner else
		}else if($seconds2 > (3600*24*7*4)){
			$sum = (integer)($seconds2 / (3600*24*7*4)) ;
			if($sum == 1){$ans = "1Mn";					}else{
			$ans = "$sum"."Mns" ;	}//end inner else
		}else if($seconds2 > (3600*24*7)){
			$sum = (integer)($seconds2 / (3600*24*7)) ;
			if($sum == 1){$ans = "1Wk";					}else{
			$ans = "$sum"."Wks" ;	}//end inner else
		}else if($seconds2 > (3600*24)){
			$sum = (integer)($seconds2 / (3600*24)) ;
			if($sum == 1){$ans = "1D";					}else{
			$ans = "$sum"."Ds" ;	}//end inner else
		}else if($seconds2 > 3600){
			$sum = (integer)($seconds2 / 3600) ;
			if($sum == 1){$ans = "1Hr";					}else{
			$ans = "$sum"."Hrs" ;	}//end inner else
		}else if($seconds2 > 300){
			$sum = (integer)($seconds2 / 60) ;
			if($sum == 1){$ans = "1Min";				}else{
			$ans = "$sum"."Mins" ;	}//end inner else
		}else{
			if($seconds2 == 1){$ans = "$seconds2"."Sec";	}else{
			$ans = "just now" ; }//end inner else
			}
		return $ans ;
	}
	function timeElapsed($timestamp){
			return timegone( getcurrtimeinfo() - timestamp_to_integer($timestamp) ) ;
	}
	function tinyTimeElapsed($timestamp){
		return tinyTimegone( getcurrtimeinfo() - timestamp_to_integer($timestamp) ) ;
	}
	
	function getWeek($week, $year) {
	  $dto = new DateTime();
	  $result['start'] = $dto->setISODate($year, $week, 0)->format('Y-m-d');
	  $result['end'] = $dto->setISODate($year, $week, 6)->format('Y-m-d');
	  return $result;
	}
	function getWeekMini($week, $year) {
	  $dto = new DateTime();
	  $result['start'] = $dto->setISODate($year, $week, 0)->format('M-j');
	  $result['end'] = $dto->setISODate($year, $week, 6)->format('M-j');
	  return $result;
	}
	function find_the_first_monday($date){
		$time = strtotime($date);
		$year = date('Y', $time);
		$month = date('m', $time);
	
		for($day = 1; $day <= 31; $day++)
		{
			$time = mktime(0, 0, 0, $month, $day, $year);
			if (date('N', $time) == 1)
			{
				return date('Y-m-d', $time);
			}
		}
	}
	
	//End Time functions
/* End of file time_functions_helper.php */
/* Location: ./application/helpers/time_functions_helper.php */