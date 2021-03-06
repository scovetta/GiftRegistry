<?php
session_start();

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

global $OPT;

/* The maximum number of days before an event which produces a notification. */
$OPT["event_threshold"] = 60;

/* Whether or not requesting to shop for someone is immediately approved. 
	0 = auto-approve,
	1 = require approval
*/
$OPT["shop_requires_approval"] = 0;

/* Whether or not requesting a new account is immediately approved.
	0 = auto-approve,
	1 = require administrator approval
*/
$OPT["newuser_requires_approval"] = 1;

/* Whether or not whom an item is reserved/bought by is hidden. */
$OPT["anonymous_purchasing"] = 0;

/* The number of your items that show on each page. */
$OPT["items_per_page"] = 10;

/* The e-mail From: header. */
$OPT["email_from"] = "noreply@scovetta.com";

/* The e-mail Reply-To: header. */
$OPT["email_reply_to"] = "noreply@scovetta.com";

/* The e-mail X-Mailer header. */
$OPT["email_xmailer"] = "PHP/" . phpversion();

/* Whether or not to show brief blurbs in certain spots which describe how 
	features work.
	0 = don't help text,
	1 = show help text
*/
$OPT["show_helptext"] = 0;

/* Whether or not clicking the Delete Item link requires a JavaScript-based
	confirmation.
	0 = don't show confirmation,
	1 = show confirmation
*/
$OPT["confirm_item_deletes"] = 1;

/* Whether or not to allow multiple quantities of an item. */
$OPT["allow_multiples"] = 1;

/* This is prefixed to all currency values, set it as appropriate for your currency. */
$OPT["currency_symbol"] = "$";	// US or other dollars      
//$OPT["currency_symbol"] = "&#163;";	// Pound (�) symbol
//$OPT["currency_symbol"] = "&#165;";	// Yen
//$OPT["currency_symbol"] = "&#8364;";	// Euro
//$OPT["currency_symbol"] = "&euro;";	// Euro alternative

/* If this is set to something other than "" then phpgiftreg will expect that
	string to prefix all tables in this installation.  Useful for running
	multiple phpgiftreg installations in the same MySQL database.
*/
$OPT["table_prefix"] = "";
//$OPT["table_prefix"] = "gift_";		// all tables must be prefixed by `gift_'

/* Whether or not your own events show up on the home page.
	0 = don't show my own events,
	1 = show my own events
*/
$OPT["show_own_events"] = 1;

/* The length of random generated passwords. */
$OPT["password_length"] = 10;

/* Whether or not to hide the price when it's $0.00.
	0 = don't hide it,
	1 = hide it
*/
$OPT["hide_zero_price"] = 1;

/* Whether or not to hash passwords.  Your version of MySQL may or may not
	support it.
	"MD5" = use MySQL's MD5() function,
	"SHA1" = use MySQL's SHA1() function,
	"" = use nothing (store passwords in plaintext).
If you switch this on, you're going to need to do a
	UPDATE users SET password = MD5(password)
on your database to convert the passwords.  This operation is NON-REVERSIBLE!
*/
$OPT["password_hasher"] = "SHA1";

/* Whether or not to allow image uploads.  If on, the next option must point to
	a valid subdirectory that is writeable by the web server.  The setup.php
	script will confirm this.
	0 = don't allow images,
	1 = allow images
*/
$OPT["allow_images"] = 1;

/* The *sub*-directory we we can store item images.  If you don't want to
	allow images to be attached to items, leave this variable empty ("").
	Trailing / is optional.
*/
$OPT["image_subdir"] = "item_images/";
?>
