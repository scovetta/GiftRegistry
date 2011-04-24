<?php
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

include("config.php");
include("db.php");
include("funcLib.php");

$error = "";

if (isset($_POST["action"])) {
	if ($_POST["action"] == "signup") {
		$username = $_POST["username"];
		$fullname = $_POST["fullname"];
		$email = $_POST["email"];
        $group_name = $_POST["group_name"];
		
		if (!get_magic_quotes_gpc()) {
			$username = addslashes($username);
			$fullname = addslashes($fullname);
			$email = addslashes($email);
			$group_name = addslashes($group_name);
		}

	    if (!isset($_SESSION["group_id"])) {
    	    $query = "SELECT group_id FROM `group` WHERE group_name = '$group_name'";
        	$rs = mysql_query($query) or die("Could not query: " . mysql_error());
	        $row = mysql_fetch_array($rs,MYSQL_ASSOC);
    	    if ($row) {
				$error = "That group name is already taken. Please choose another.";
    		    mysql_free_result($rs);
        	} else {
				$query = "INSERT INTO {$OPT["table_prefix"]}\`group\` (group_name) VALUES ('$group_name')";
				mysql_query($query) or die("Could not query: " . mysql_error());

	    	    $query = "SELECT group_id FROM `group` WHERE group_name = '$group_name'";
    	    	$rs = mysql_query($query) or die("Could not query: " . mysql_error());
	    	    $row = mysql_fetch_array($rs,MYSQL_ASSOC);
        	    $_SESSION["group_id"] = $row["group_id"];
	        }
    	}

		// make sure that username isn't taken.
		$query = "SELECT userid FROM {$OPT["table_prefix"]}users WHERE username = '$username' and group_id = " . $_SESSION["group_id"];
		$rs = mysql_query($query) or die("Could not query: " . mysql_error());
		if (mysql_num_rows($rs) > 0) {
			$error = "The username '" . stripslashes($username) . "' is already taken.  Please choose another.";
			mysql_free_result($rs);
		}
		else {
			mysql_free_result($rs);
			
			// generate a password and insert the row.
			// NOTE: if approval is required, this password will be replaced
			// when the account is approved.
			$pwd = generatePassword();
			$query = "INSERT INTO {$OPT["table_prefix"]}users(username,group_id,fullname,password,email,approved,initialfamilyid) VALUES('$username'," . $_SESSION["group_id"] . ",'$fullname',{$OPT["password_hasher"]}('$pwd'),'$email'," . ($OPT["newuser_requires_approval"] ? "0" : "1") . ",$familyid)";
			mysql_query($query) or die("Could not query: " . mysql_error());
			
			if ($OPT["newuser_requires_approval"]) {
				// send the e-mails to the administrators.
				$query = "SELECT fullname, email FROM {$OPT["table_prefix"]}users WHERE admin = 1 AND email IS NOT NULL AND group_id = " . $_SESSION["group_id"];
				$rs = mysql_query($query) or die("Could not query: " . mysql_error());
				while ($row = mysql_fetch_assoc($rs)) {
					mail(
						$row["email"],
						"Gift Registry approval request for " . stripslashes($fullname),
						stripslashes($fullname) . " <" . stripslashes($email) . "> would like you to approve him/her for access to the Gift Registry.",
						"From: {$OPT["email_from"]}\r\nReply-To: {$OPT["email_reply_to"]}\r\nX-Mailer: {$OPT["email_xmailer"]}\r\n"
					) or die("Mail not accepted for " . $row["email"]);
				}
				mysql_free_result($rs);
			}
			else {
				// we don't require approval, 
				// so immediately send them their initial password.
				// also, join them up to their initial family (if requested).
				if ($familyid != "NULL") {
					$query = "SELECT userid FROM {$OPT["table_prefix"]}users WHERE username = '$username' AND group_id = " . $_SESSION["group_id"];
					$rs = mysql_query($query) or die("Could not query: " . mysql_error());
					$row = mysql_fetch_assoc($rs);
					$userid = $row["userid"];
					mysql_free_result($rs);
			
					$query = "INSERT INTO {$OPT["table_prefix"]}memberships(userid,group_id,familyid) VALUES($userid," . $_SESSION["group_id"] . ",$familyid)";
					echo $query;
					mysql_query($query) or die("Could not query: " . mysql_error());					
				}

				mail(
					$email,
					"Gift Registry account created",
					"Your Gift Registry account was created.\r\n" . 
						"Your username is $username and your password is $pwd.",
					"From: {$OPT["email_from"]}\r\nReply-To: {$OPT["email_reply_to"]}\r\nX-Mailer: {$OPT["email_xmailer"]}\r\n"
				) or die("Mail not accepted for $email");	
			}
		}
		
	}
}
?>
<?php include("../header.html"); ?>
<link href="styles.css" type="text/css" rel="stylesheet" />

<script language="JavaScript" type="text/javascript">
	function validateSignup() {

		field = document.signup.group_name;
		if (field == null || field == undefined || !field.value.match("\\S")) {
			alert("You must supply a group name.");
			field.focus();
			return false;
		}

		field = document.signup.username;
		if (field == null || field == undefined || !field.value.match("\\S")) {
			alert("You must supply a username.");
			field.focus();
			return false;
		}
		
		field = document.signup.fullname;
		if (field == null || field == undefined || !field.value.match("\\S")) {
			alert("You must supply your full name.");
			field.focus();
			return false;
		}
		
		field = document.signup.email;
		if (!field.value.match("\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*")) {
			alert("The e-mail address '" + field.value + "' is not a valid address.");
			field.focus();
			return false;
		}
		
		return true;
	}
</script>

<?php
if (isset($_POST["action"]) && $_POST["action"] == "signup" && $error == "") {
	// success!
	?>
	<p>
		Thank you for signing up.
	</p>
	<?php
	if ($OPT["newuser_requires_approval"])
		echo "<p>The administrators have been informed of your request and you will receive an e-mail once they've made a decision.</p>";
	else
		echo "<p>Shortly, you will receive an e-mail with your initial password.</p>";
	echo "<p>Once you've received your password, click <a href=\"login.php\">here</a> to login.</p>";
}
else {
	?>
	<form name="signup" method="post" action="group.php">	
		<input type="hidden" name="action" value="signup">
		<div align="center">
			<table cellpadding="3" class="partbox" width="50%">
				<tr>
					<td colspan="2" class="partboxtitle" align="center">Sign Up for the Gift Registry</td>
				</tr>
				<tr>
					<td colspan="2">
						<p>
							Complete the form below and click Submit.  
						</p>
						<?php
						if ($OPT["newuser_requires_approval"]) {
							?>
							<p>
								The list administrators will be notified of your request by e-mail and will approve or decline your request.
							</p>
							<p>
								If the e-mail address you supply is valid, you will be notified once a decision is made.
							</p>
							<?php
						}
						else {
							?>
							<p>
								If the e-mail address you supply is valid, 
								you will shortly receive an e-mail with your
								initial password.
							</p>
							<?php
						}
						if ($error != "")
							echo "<div class=\"message\">" . $error . "</div>";
						?>
					</td>
				</tr>
				<tr>
					<td width="25%">Group Name</td>
					<td>
						<input name="group_name" size="20" maxlength="20" type="text" value="<?php if (isset($_POST["group_name"])) echo htmlspecialchars(stripslashes($_POST["group_name"])); ?>"/>
					</td>
				</tr>
				<tr>
					<td width="25%">Username</td>
					<td>
						<input name="username" size="20" maxlength="20" type="text" value="<?php if (isset($_POST["username"])) echo htmlspecialchars(stripslashes($_POST["username"])); ?>"/>
					</td>
				</tr>
				<tr>
					<td>Full name</td>
					<td>
						<input name="fullname" size="30" maxlength="50" type="text" value="<?php if (isset($_POST["fullname"])) echo htmlspecialchars(stripslashes($_POST["fullname"])); ?>" />
					</td>
				</tr>
				<tr>
					<td>E-mail address</td>
					<td>
						<input name="email" size="30" maxlength="255" type="text" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>" />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="Submit" onClick="return validateSignup();" />
					</td>
				</tr>
			</table>
		</div>
	</form>
	<?php
}
?>
<?php include("../footer.html"); ?>
