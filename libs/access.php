<?php
/**
 * this library will be used to load access data to session as well
 * as to check certain access rules
 * dependency: db library, error library database should be coonected
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}
 
 //======================================================\\
 
 /**
  * Exception to handle Invalid userid
  */
class NullUserId extends Exception { };
class noAccess extends Exception { };
/**
 * Actual access class to handle user access
 */
class access
{
	private $userId = null;
	private $isSessionSetVar = false;
	//public $accessLevel = Array(); //to be used later if its better
	/**
	 * constructor
	 * @param: user id as int
	 * also calls a function to check for existing access session
	 */
	function __construct($id)
	{
		if( $id == "" || $id == null )
			 throw new NullUserId('UserId cannot be null!');
		/**
		 * can check for int value of userId later
		 */
		$this->userId = $id;
		
		if($this->checkSession()) $isSessionSetVar = true;
	}
	/**
	 * function to check if ACCESS data is set in session already
	 */
	private function checkSession()
	{
		if( isset($_SESSION['ACCESS_DATA']) && ($_SESSION['ACCESS_DATA'] === true) ) return true;
		return false;
	}
	
	/** 
	 * this function returns if session is already set or 
	 *  need to be fetched
	 */
	public function isSessionSet()
	{
		return $this->isSessionSetVar;
	}
	
	/**
	 * this function fetches the user access from db
	 * and save it to session so that it can be accessed by 
	 * other functions later
	 */
	public function getAccessFromDB()
	{
		if( $this->userId == null || $this->userId == "" )
			 throw new NullUserId('UserId cannot be null!');
		$query = mysql_query("SELECT acl.access FROM useraccess 
								INNERJOIN acl ON acl.accessId = useraccess.accessId
								WHERE userId = '" .$this->userId ."'");
		if(!$query)
		{
			throw new dbError(mysql_error());
			return;
		}
		if( !mysql_num_rows($query) )
		{
			throw new noAccess('User does not have any access. Program cannot continue');
			return;
		}
		$_SESSION['ACCESS'] = Array();
		while( $row = mysql_fetch_array($query) )
		{
			$_SESSION['ACCESS'][$row['access']] = true;
			//$this->accessLevel[$row['access']] = true;
			//for direct usage from class object
		}
		$_SESSION['ACCESS_DATA'] = true;
		return;
	}

}; 