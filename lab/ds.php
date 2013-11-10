<?php 
$time = time();
$tableName = array(
	"ADD_EMAIL_GROUP" => "INSERT INTO 'group_subscriber' ('user_id', 'group_id') VALUES ('ielem','jelem');",
	"ADD_EMAIL" => "INSERT INTO `subscribers`(`email`, `date`) VALUES ('ielem','$time');",
	"REMOVE_EMAIL" => "DELETE s,g FROM subscribers s INNER JOIN group_subscribers g ON g.subscriber_id = s.id WHERE s.id = 'ielem'; ",
	"REMOVE_EMAIL_GROUP" => "DELETE FROM 'group_subscriber' WHERE user_id = 'ielem' AND group_id = 'jelem';",
	"REMOVE_GROUP" => "DELETE FROM `group` WHERE id = 'ielem';",
	"EDIT_EMAIL_EMAIL" => "UPDATE `subscribers` SET email = 'jelem' WHERE id = 'ielem';"
);


$actionDetail = array(
	"ADD" => " Insert operation to database ",
	"REMOVE" => "Delete operation from database ",
	"EDIT" => " Update operation on database "
);
/**
 * bug: sometime we need to fix multiple tables for one operation 
 * like in cas of removing subscriber: we need to delete corresponding data from 
 * group_subscriber as well
 * Fix: by using inner JOIN as we are working on mysql   
 */

?>