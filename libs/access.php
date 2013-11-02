<?php
/**
 * this library will be used to load access data to object of this class as well
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
	public $accessLevel = Array(); 
	
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
								INNER JOIN acl ON acl.accessId = useraccess.accessId
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
		while( $row = mysql_fetch_array($query) )
		{
			$this->accessLevel[$row['access']] = true;
		}
		return;
	}

}; 