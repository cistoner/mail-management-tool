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
	var multiple = document.getElementById('addMultEmail').value;
	if(!email.length && !multiple.length)
	{
		$("#addEmailid").attr("value","");
		$("#addEmailid").attr("placeholder","enter valid email id");
		return;
	}
	if(email.length)
	{
		if( !validateEmail(email) ) 
		{
			$("#addEmailid").attr("value","");
			$("#addEmailid").attr("placeholder","enter valid email id");
			return;
		}
		var csq = "ADD EMAIL {" +email +"}";
	}
	else if(multiple.length)
	{
		var emails = multiple.split(',');
		var i = 0;
		for(i = 0;i < emails.length;i++)
		{
			if(!validateEmail(emails[i]))
			{
				$("#addMultEmail").html("");
				$("#addMultEmail").attr("placeholder","Some of the email were invalid");
				return;
			}
		}
		while(multiple[multiple.length-1] == ',')
		{
			multiple = multiple.substr(0,multiple.length-2);
		}
		var csq = "ADD EMAIL {" +multiple +"}";
	}
	
    var feedback = sendCSQ(csq,"displayTable tbody",4);
	
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
    sendCSQ(csq,"displaytablebody",6);
}

/**
 * function to send the csq to server
 * and retrieve the feedback
 */
function sendCSQ(csq,outputid,cols)
{
    var data;
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
                else if(result == 13 || result == "13")alert("You do not have access to do this!");
                else
                {
                    /**
                     * manipulate the feedback
                     */
					if(result.length)
					{
						var rows = result.split('^');
						var output = "";
						var i;
						var j;
						for(i = 0;i < rows.length - 1;i++)
						{
							var colData = rows[i].split('~');
							output += "<tr>";
							for(j = 0;j < cols;j++)
							{
								console.log(rows[i]);
								output += "<td>";
								if(j < colData.length - 1)
								{
									output += colData[j];
								}
								else output += " -- ";
								output += "</td>";
							}
							output += "</tr>";
						}
						$("#" +outputid).prepend(output);
					}
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
