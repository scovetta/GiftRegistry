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

if (isset($_GET["action"])) {
	if ($_GET["action"] == "logout") {
		session_start();
		session_destroy();
	}
}

if (!empty($_POST["username"])) {
	include "db.php";
	$username = $_POST["username"];
	$password = $_POST["password"];
	$group_name   = $_POST["group_name"];
	if (!get_magic_quotes_gpc()) {
		$username = addslashes($username);
		$password = addslashes($password);
		$group_name = addslashes("group_name");
	}

	if (!isset($_SESSION["group_id"])) {
	   	$query = "SELECT group_id FROM `group` WHERE group_name = '$group_name'";
    	$rs = mysql_query($query) or die("Could not query: " . mysql_error());
	    $row = mysql_fetch_array($rs,MYSQL_ASSOC);
		if (!$row) {
	    	mysql_free_result($rs);
    		header("Location: " . getFullPath("login.php?nofamily"));
	        exit;
		} else {
        	$group_id = $row["group_id"];
	    	mysql_free_result($rs);
		    $_SESSION["group_id"] = $group_id;
		}
   	}

	$query = "SELECT userid, fullname, admin FROM users WHERE group_id=$group_id AND username = '$username' AND password = {$OPT["password_hasher"]}('$password') AND approved = 1";
	$rs = mysql_query($query) or die("Could not query: " . mysql_error());
	if ($row = mysql_fetch_array($rs,MYSQL_ASSOC)) {
		session_start();
		$_SESSION["userid"] = $row["userid"];
		$_SESSION["fullname"] = $row["fullname"];
		$_SESSION["admin"] = $row["admin"];
		header("Location: " . getFullPath("index.php"));
		mysql_free_result($rs);
		exit;
	}
}
?>
<?php include("../header.html"); ?>
<link href="styles.css" type="text/css" rel="stylesheet" />

<form name="login" method="post" action="login.php">	
	<div align="center">
		<img src="images/logo.png" border="0" alt="Gift Registry" title="Scovetta XMAS Registry" width="300"/>
	</div>
	<div align="center">
		<table cellpadding="3" class="partbox">
			<?php
			if (isset($_POST["username"])) {
				echo "<caption><font color=\"red\">Bad login.</font></caption>";
			}
			?>
			<tr>
				<td colspan="2" class="partboxtitle" align="center">Login to the Scovetta XMAS Registry</td>
			</tr>
			<tr>
				<td>Family Name</td>
				<td>
					<input name="family" type="text" style="width:200px"/>
				</td>
			</tr>
			<tr>
				<td>Username</td>
				<td>
					<input name="username" type="text" style="width:200px"/>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input name="password" type="password" style="font-family:'Times New Roman', Serif;width:200px"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Login"/>
				</td>
			</tr>
		</table>
	</div>
	<p>
		<div align="center">
			<a href="signup.php">Need an account?</a>
		</div>
	</p>
	<p>
		<div align="center">
			<a href="forgot.php">Forgot your password?</a>
		</div>
	</p>
</form>
<?php include("../footer.html"); ?>
