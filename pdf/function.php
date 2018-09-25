<?php
class CustomHelper{
 public function number_to_words($number) {
            $words = array(
                '0'=> '' , '1'=> 'One', '2'=> 'Two', '3' => 'Three', '4' => 'Four', 
                '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight','9' => 'Nine', '10' => 'Ten',
                '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fouteen', '15' => 'Fifteen',
                '16' => 'Sixteen', '17' => 'Seventeen', '18' => 'Eighteen', '19' => 'Nineteen', 
                '20' => 'Twenty', '30' => 'Thirty', '40' => 'Fourty', '50' => 'Fifty', '60' => 'Sixty',
                '70' => 'seventy', '80' => 'Eighty', '90' => 'Ninty', '100' => 'hundred',
                '1000' => 'Thousand', '100000' => 'Lakh', '10000000' => 'Crore'
                );
            
        if($number == 0) {
            return ' ';
        } else {
            $novalue='';
            $highno = $number;
            $remainno = 0;
            $value = 100;
            $value1 = 1000;       
            while($number >= 100)    {
                if(($value <= $number) &&($number  < $value1))    {
                $novalue=$words["$value"];
                $highno = (int)($number / $value);
                $remainno = $number % $value;
                break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }       
          if(array_key_exists("$highno",$words)) {
              return $words["$highno"]." ".$novalue." ".$this->number_to_words($remainno);
          } else {
             $unit=$highno % 10;
             $ten =(int)($highno/10) * 10;            
             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->number_to_words($remainno);
           }
        }
    }
    
    //function for decimal parts
 function forDecimal($num){
	 
	$th= (int)($num/1000); 
	$x = (int)($num/100) %10;
	$fo= explode('.',$num);
	$num =(float)$num;
	$check = (int) $num;
	print_r($check);exit;
    global $ones,$tens;
    $str="";
    $len = strlen($num);
    if($len==1){
        $num=$num*10;
    }
    $x= $num%100;
    if($x>0){
    if($x<20){
        $str = $ones[$x].' Paise';
    }else{
        $str = $ones[$x/10].$ones[$x%10].' Paise';
    }
    }
     return $str;
 }  
	
	function numberFormate($num){
		return number_format($num,2);	
	}
}
?>
