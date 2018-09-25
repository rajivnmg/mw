<?php
//include("../DBModel/Enum_Model.php");
//include("../DBModel/DbModel.php");
class ParamModel{

    public $_paramValue1;
    public $_param1;

    public static function GetFinYearList()
    {
        $Query = "select * from finyear_master ORDER BY finyearid DESC";
        $Result = DBConnection::SelectQuery($Query);
        return $Result;
    }
    public static function GetCurrentYear()
    {
        $Query = "select * from finyear_master where year_status = 'C'";
        $Result = DBConnection::SelectQuery($Query);
        return $Result;
    }
public static function getFinYear()
	    {
			$data = file_get_contents("../../finyear.txt"); //read the file
			$convert = explode("\n", $data); //create array separate by new line
	        $finyear=trim($convert[0]); 
	        return $finyear;
        }

    public function __construct($paramValue1,$param1){
            $this->_paramValue1 = $paramValue1;
            $this->_param1 = $param1;
    }
    public static function GetParamList($PARAMTYPE,$PARAMCODE){
            $Query = "SELECT PARAM_VALUE1,PARAM_VALUE2,PARAM1,COMP_NAME,USERID FROM param WHERE PARAM_TYPE='$PARAMTYPE' AND PARAM_CODE='$PARAMCODE' AND STATUS='Y'";
            $Result = DBConnection::SelectQuery($Query);
            return $Result;
    }

    public static function CountRecord($tableName,$Type){
         $Query = "SELECT COUNT(*) as total FROM ".$tableName;
         if($tableName == "principal_supplier_master" && $Type == "P"){
            $Query = $Query." WHERE  TYPE = 'P'";
         } else if($tableName == "principal_supplier_master" && $Type == "S") {
            $Query = $Query." WHERE TYPE = 'S'";
         }
         $Result = DBConnection::SelectQuery($Query);
         $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
         return $Row["total"];
    }
    public static function GetCompanyInfo(){
         $Query = "select * from company_info";
         $Result = DBConnection::SelectQuery($Query);
         $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
         return $Row;
    }
    public static function getSystemDate(){
	        $Query ="SELECT DATE_FORMAT(CURDATE(), '%d/%m/%Y') sdate";
		    $Result = DBConnection::SelectQuery($Query);
		    $row=mysql_fetch_array($Result, MYSQL_ASSOC);
		 	        $sysDate=$row['sdate'];
			        return $sysDate;
    }
	
	 public function GetVATCSTBYId($id){
		$Query = "select * from vat_cst_master WHERE SALESTAX_ID =$id"; 
        $Result = DBConnection::SelectQuery($Query);
		 $row=mysql_fetch_array($Result, MYSQL_ASSOC);
		return $row;
	}
	
   }
?>