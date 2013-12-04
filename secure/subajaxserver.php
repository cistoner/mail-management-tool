<?php
/**
 * page for handeling all ajax queries not dealt with CSQ
 */
if(!isset($_POST['retrieve']) || $_POST['retrieve'] != 'true')
{		
	echo "1001: Insufficient parameters!";
	exit;
}
	
/**
 * Including all required files and libraries
 * that might be required for operation
 */
include '../config/config.php';
include '../libs/error.php';
include '../libs/db.php';
include '../libs/log.php';
include '../libs/access.php';
include '../libs/login.php';

/**
 * Code to authenticate the admin
 * from existing data in session
 */
include 'authentication.php';

/**
 * including other libraries
 * now that user is authenticated
 */

include '../libs/subscriber.php';
include '../libs/groups.php';
include '../libs/mail.php';

/**
 * function to check if any data was sent as post
 */
function sent($param)
{
	if(isset($_POST[$param]))return true;
	return false;
}

if(sent('object') && sent('limit') && sent('page') &&sent('key'))
{
	$obj = $_POST['object'];
	$limit = $_POST['limit'];
	if($limit == "" || (int)$limit == 0)$limit = 20;
	$page = $_POST['page'];
	if($page == "" || (int)$page == 0)$page = 1;	
	$key = $_POST['key'];
	dbase::start_connection();
	if($obj == "mailids")
	{
		$subsObj = new subscribers($limit,$page);
		$subsObj->getSubscribers($key);
		$len = count($subsObj->subs);
		for($i = 0; $i<$len; $i++)
		{
			echo '<tr class="odd">';
			echo "<td><input type='checkbox' name='id[]' id='mailid' class='select' value='" .$subsObj->subs[$i]['id'] ."'></td>";
			echo "<td class='sorting_'>" .$subsObj->subs[$i]['email'];
			echo "</td>";
			echo "<td class='center'>" .$subsObj->subs[$i]['date'] ."</td>";
			echo "<td class='center '>";
			$nos = count($subsObj->subs[$i]['group']);
			for($j = 0; $j<$nos; $j++)
			{
				echo "<span class='label label-important'>" .$subsObj->subs[$i]['group'][$j]['gp_name'] ."</span> ";
			}
			echo "</td>";
			echo "<td class='center'></td>";
			echo '</tr>';
		}
	}
	else
	{
		echo "1001:invalid parameters";exit;
	}
	dbase::close_connection();
	exit;
}
?>