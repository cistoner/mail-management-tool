/**
 * this will serve as js file for all operations
 * that need js and need to be added to usman's template
 */
 
/**
 * task 1: adding email to db manually
 * csq: ADD EMAIL {<email_id>}
 */
var sendMail = false;

/**
 * function to add email to db
 */
function addEmail()
{
	var email = document.getElementById('addEmailid').value;
	var csq = "ADD EMAIL {" +email +"}";
	if( !validateEmail(email) ) 
	{
		$("#addEmailid").attr("value","");
		$("#addEmailid").attr("placeholder","enter valid email id");
		return;
	}
    sendCSQ(csq,"displayTable tbody");
}

/**
 * function to add a group
 * to mmt
 */
function addGroup()
{
    var grp = document.getElementById('addgrpid').value;
    var desc = document.getElementById('adddesc').value;
    if(grp.length == 0 || grp =="" ||grp == null)
    {
        $("#addgrpid").attr("value","");
        $("#addgrpid").attr("placeholder","enter valid group name");
        return;
    }

    if(desc.indexOf("~&") != -1)
    {
        desc = desc.replace("~&","\~\&");
    }
    var csq = "ADD GROUP {'" +grp +"'~&'" +desc +"'}";
    sendCSQ(csq,"displayTable tbody");
}

/**
 * function to send the csq to server
 * and retrieve the feedback
 */
function sendCSQ(csq,outputid)
{
    $.post("secure/ajaxserver.php",
        {
            csq: csq
        },
        function(result,status){
            if(status=="success")
            {
                /**
                 * not logged in case
                 */
                if(result == -1 || result == "-1") window.location.href = 'login.php?success=false&message=login+first+to+continue';
                else if(result == -2 || result == "-2") alert("You do not have access to do this!");
                else if(result == 13 }} result == "13")alert("You do not have access to do this!");
                else
                {
                    /**
                     * manipulate the feedback
                     */
                    $("#" +outputid).prepend(result);
                    console.log("FEEDBACK: "+result);
                }
            }
            else
            {
                alert("Unable to connect!");
            }
        });
}

/**
 * function to validate email ids
 */
function validateEmail(email)
{
	if(email.indexOf("@") == -1 || email.indexOf(".") == -1) return false;
	if( (email.indexOf("@") + 2 ) > email.lastIndexOf(".") ) return false;
	return true;
}
