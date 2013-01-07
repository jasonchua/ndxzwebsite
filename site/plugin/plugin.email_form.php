<?php if (!defined('SITE')) exit('No direct script access allowed');
/**
* email_form_sender
*
* Plugin
* 
* @version" 2.0
* @author: James Dodd
*
* @revision notes: 
*
*
**/

function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
↪([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function contact_form(){
	return '
	
	<script language="Javascript" type="text/javascript">
	/*<![CDATA[*/
		function checkform() {
		  for (i=0;i<fieldstocheck.length;i++) {
		    if (eval("document.myForm.elements[\'"+fieldstocheck[i]+"\'].type") == "checkbox") {
		      if (document.myForm.elements[fieldstocheck[i]].checked) {
		      } else {
		        alert("Please enter your "+fieldnames[i]);
		        eval("document.myForm.elements[\'"+fieldstocheck[i]+"\'].focus()");
		        return false;
		      }
		    }
		    else {
		      if (eval("document.myForm.elements[\'"+fieldstocheck[i]+"\'].value") == "") {
		        alert("Please enter your "+fieldnames[i]);
		        eval("document.myForm.elements[\'"+fieldstocheck[i]+"\'].focus()");
		        return false;
		      }
		    }
		  }
		  for (i=0;i<groupstocheck.length;i++) {
		    if (!checkGroup(groupstocheck[i],groupnames[i])) {
		      return false;
		    }
		  }
		  return true;
		}
		
		var fieldstocheck = new Array();
		var fieldnames = new Array();
		function addFieldToCheck(value,name) {
		  fieldstocheck[fieldstocheck.length] = value;
		  fieldnames[fieldnames.length] = name;
		}
		var groupstocheck = new Array();
		var groupnames = new Array();
		function addGroupToCheck(value,name) {
		  groupstocheck[groupstocheck.length] = value;
		  groupnames[groupnames.length] = name;
		}
		
		function checkGroup(name,value) {
		  option = -1;
		  for (i=0;i<document.myForm.elements[name].length;i++) {
		    if (document.myForm.elements[name][i].checked) {
		      option = i;
		    }
		  }
		  if (option == -1) {
		    alert ("Please enter your "+value);
		    return false;
		  }
		  return true;
		}
		
	/*]]>*/
	</script>

	<div id="contact_form">
		<form method="post" name="myForm" action="">
			<table>
				<tr>
					<td>Name</td>
					<td><input name="name" type="text" id="name"  /><script language="Javascript" type="text/javascript">addFieldToCheck("name","Name");</script></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input name="customer_mail" type="text" id="customer_mail"/><script language="Javascript" type="text/javascript">addFieldToCheck("customer_mail","Email");</script></td>
				</tr>
				<tr>
					<td>Message</td>
					<td><textarea name="detail" id="detail" rows="10" cols="40"></textarea><script language="Javascript" type="text/javascript">addFieldToCheck("detail","Message");</script></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
					<input type="submit" name="submitButton" value="Submit" class="submit" onclick="return checkform();" />
					</td>
				</tr>
			</table>
		</form>
	</div>';			
}

function error_message($message){
	return '
	<h3>Message Not Sent</h3>
	<p>'.$message.'</p>
	<p><a href="javascript:history.go(-1); nofollow;">Click here to go back</a></p>
	';
}

function thanks_message($message){
	return '
	<h3>Message Sent</h3>
	<p>'.$message.'</p>
	';
}

function email_form($yourmail=false, $return_message='Thank you for your message. We\'ll contact you shorty.', $error_message='There was an error. please try again ensuring make sure all the fields are filled out', $email_subject='Web form email indexhibit site'){
	$OBJ =& get_instance();

	if(isset($_POST['name'])){$name=$_POST['name'];}
	if(isset($_POST['customer_mail'])){$email=$_POST['customer_mail'];}
	if(isset($_POST['detail'])){$message=stripslashes($_POST['detail']);}
	if(isset($_POST['submitButton'])){$submit=$_POST['submitButton'];}
	if(isset($submit)){
		if(check_email_address($email) && $message && $name){
			// subject
			$subject =$email_subject;
			// From
			$header="from: $name <$email>";
			// Enter your email address
			$to =$yourmail;
			$send_contact=mail($to,$subject,$message,$header);
			// Check, if message sent to your email	
			if($send_contact){
				return thanks_message($return_message);
			}
			else {
				return error_message($error_message);
			}
		}
		else {
			return error_message($error_message);
		}	
	}
	else{
		return contact_form();	
	}
}


?>