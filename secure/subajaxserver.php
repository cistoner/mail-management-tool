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
 * for retrieving all access for this user
 */
$accessObj = new access($_SESSION['id']);

/*
 * ignoring the noacess case for now
 */
try
{
	$accessObj->getAccessFromDB();
}
catch(noAccess $ex)
{
	/* do nothig for now */		
}

/**
 * function to check if any data was sent as post
 */
function sent($param)
{
	if(isset($_POST[$param]))return true;
	return false;
}

/**
 * for searching and pagination
 */
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
		if($len == 0)
		{
			echo '<tr class="odd"><td colspan="5" style="text-align: center" > Ooops! Couldn\'t fetch anything usefull!</td></tr>';
		}
		for($i = 0; $i<$len; $i++)
		{
			echo '<tr class="odd" id_="' .$subsObj->subs[$i]['id'] .'" check="false">';
			echo "<td class='selector_icon'><img id='tick_img' title='click to select' src='img/hector09/ok.png' width='20px'></td>";
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

/**
 * for deleting ids from db
 */
if( sent('object') && sent('ids') && sent('task') ) 
{
	$task = $_POST['task'];
	$ids = $_POST['ids'];
	switch($task)
	{
		case "delete": 
			if(isset($accessObj->accessLevel['email-D']) && $accessObj->accessLevel['email-D'] === true )
			{
				$arr = explode("_",$ids);
				$len = count($arr);
				dbase::start_connection();
				foreach($arr as $id)
				{
					if($id)
					{
						$query = mysql_query("DELETE FROM subscribers WHERE id = '$id';");	
						if(!$query){echo mysql_error();exit;}
					}
				}
				dbase::close_connection();
				echo 1;
				exit;
			}
			else
			{
				echo "You do not have required access!";
				exit;
			}
			break;
		default: echo "Unknown header!";exit;break;
	}
}

?>