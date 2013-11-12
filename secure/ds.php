<?php
/**
 * This is the data-store of CSQ [ Custom Structured Query ]
 * This store contains
 *  * Array to store queries structure
 *  * Array to store Access for any operation
 */
if(!isset($checkVar))
{
    header("location: ../../index.php");
    exit;
}

$time = time();

/**
 * Array to store the queries format
 * this types of queries work for 1-degree and 2-degree CSQ
 */
$sqlstruct = array(
	"ADD_EMAIL_GROUP" => "INSERT INTO 'group_subscriber' ('user_id', 'group_id') VALUES ('ielem','jelem');",
	"ADD_EMAIL" => "INSERT INTO `subscribers`(`email`, `date`) VALUES ('ielem','$time');",
	"REMOVE_EMAIL" => "DELETE s,g FROM subscribers s INNER JOIN group_subscribers g ON g.subscriber_id = s.id WHERE s.id = 'ielem'; ",
	"REMOVE_EMAIL_GROUP" => "DELETE FROM 'group_subscriber' WHERE user_id = 'ielem' AND group_id = 'jelem';",
	"REMOVE_GROUP" => "DELETE FROM `group` WHERE id = 'ielem';",
	"EDIT_EMAIL_EMAIL" => "UPDATE `subscribers` SET email = 'jelem' WHERE id = 'ielem';",
    "ADD_GROUP" => "INSERT INTO `group`(`name`, `description`, `date`, `admin_id`) VALUES ( ielem ,'$time','" .$_SESSION['id'] ."');"
);

/**
 * Array to store access required for each operation
 * this shall be used to check access for any CSQ
 */
$accessData = array(
    "ADD_EMAIL_GROUP" => "group-AE",
    "ADD_EMAIL" => "email-A",
    "REMOVE_EMAIL" => "email-D",
    "REMOVE_EMAIL_GROUP" => "group-RE",
    "REMOVE_GROUP" => "group-D",
    "EDIT_EMAIL_EMAIL" => "email-E",
    "ADD_GROUP" => "group-A"
);

/**
 * feedback query db
 */
 $feedbackQuery = array(
	"ADD_EMAIL" => "SELECT email FROM subscribers WHERE email = 'ielem';",
	"ADD_GROUP" => "SELECT `id`, `name` FROM `group` ORDER BY `id` DESC LIMIT 1;"
 );
?>