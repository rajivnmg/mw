<?php
class StateMasterModel  {
	
   public $_stateId;
   public $_stateName;
   public $tin_no;
   public $_stateCode;
   private $_createdId;
   private $_createDate;
    
	public function __construct($stateId,$stateName,$createdId,$createDate,$_stateCode,$tin_no){
		$this->_stateId = $stateId;
		$this->tin_no = $tin_no;
		$this->_stateName = $stateName;
		$this->_stateCode = $_stateCode;
		$this->_createdId = $createdId;
		$this->_createDate = $createDate;
	}
	public static function  LoadAll($STATEID)
	{
	if($STATEID>0)
	{
		$result = self::GetStateDetails($STATEID);
	}
	else{
		$result = self::GetStateList();
	}
		
		$objArray = array();
		$i = 0;
		
		while ($Row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    		
    		$_stateId = $Row['StateId'];
		 	$_stateName = $Row['StateName'];
		 	$tin_no = $Row['tin_no'];
		 	$_stateCode = $Row['state_code'];
		 	$_createdId = $Row['UserId'];
		 	$_createDate = $Row['InsertDate'];
		 	$newObj = new StateMasterModel($_stateId,$_stateName,$_createdId,$_createDate,$_stateCode,$tin_no);
		 	$objArray[$i] = $newObj;
		 	$i++;
    		
		}
		return $objArray;
	}
	public static function InsertState($StateName, $CreatorID){
		$Resp = self::CheckStateName($StateName);
		if($Resp == QueryResponse::NO){
			$date = date("Y-m-d");
			// added on 01-JUNE-2016 due to Handle Special Character
			$StateName = mysql_escape_string($StateName);
			$Query = "INSERT INTO state_master (StateName,UserId,InsertDate) VALUES ('$StateName','$CreatorID','$date')"; 
			$Result = DBConnection::InsertQuery($Query);
			if($Result == QueryResponse::SUCCESS){
				return QueryResponse::YES;
			}
			else{
				return QueryResponse::NO;
			}
		}
	    else{
			return QueryResponse::NO;
		}
	}
	private static function CheckStateName($StateName){
		$Query = "SELECT StateName FROM state_master WHERE StateName = '$StateName'"; 
		$Result = DBConnection::SelectQuery($Query);
        $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
		if($Row['StateName'] == $StateName){
			return QueryResponse::YES;
		}
		else{
			return QueryResponse::NO;
		}
	}
	public static function UpdateState($StateID, $StateName){
		// added on 01-JUNE-2016 due to Handle Special Character
		$StateName = mysql_escape_string($StateName);
		$Query = "UPDATE state_master SET StateName = '$StateName' WHERE StateId = '$StateID'"; 
        $Resp = self::CheckStateName($StateName);
        if($Resp == QueryResponse::NO){
			$Result = DBConnection::UpdateQuery($Query);
            if($Result == QueryResponse::SUCCESS){
                return QueryResponse::YES;
            }
            else{
                return QueryResponse::NO;
            }
		}
	    else{
			return QueryResponse::NO;
		}
		
	}
	public static function GetStateList(){
		$Query = "SELECT * FROM state_master"; 
        
		$Result = DBConnection::SelectQuery($Query);;
		return $Result;
	}
	public static function GetStateDetails($STATEID)
	{
		$Query = "SELECT * FROM state_master WHERE StateId = $STATEID";  
        
		$Result = DBConnection::SelectQuery($Query);;
		return $Result;
	}
}
?>
