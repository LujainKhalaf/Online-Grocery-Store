<?php
session_start();
if (!isset($_SESSION["currentLogin"]))
{
    $_SESSION["currentLogin"] = null;
}

if (isset($_GET['user'])) {
	if (substr($_GET['user'],0,6) == "delete") {
		$deleteUser =
		"<form name='toDelete' id='toDelete' method='POST' action='../php/editUser.php' type='submit'><input id=toDelete name='toDelete' value='".substr($_GET['user'],6)."'/></form>
		<script>document.getElementById(\"toDelete\").submit();</script>";
		echo $deleteUser;
	}
}

$doc = new DOMDocument();
$doc->load("../data.xml");

$usersTop =
"
<div style='text-align:center;'>
	<br/><br/>
	<h1 style='margin:2%; font-size:36px;'>Edit a User</h1>
		<button class='item_btn_aisle' style='font-size:32px; padding:1%; padding-left:3%; padding-right:3%; margin:1%;' value=''/>Save Changes</button>
</div>
<tr> 
	<div class='edit_user_head'>

		<div class='edit_item'>
			<h2>Username</h2>
		</div>
	
		<div class='edit_item'>
			<h2>E-mail</h2>
		</div>

        <div class='edit_item'>
            <h2>Password</h2>
        </div>

        <div class='edit_item'>
            <h2>Confirm Password</h2>
        </div>

        <div class='edit_item'>
            <h2>Admin?</h2>
        </div>
    </div>
</tr>
<hr style='margin:2%; margin-top:0%;'/><br/>";

$users = [];
$usernames = [];
$passwords = [];
$emails = [];
$admins = [];

function loadUsers() {
	global $oldusername;
	if (isset($_GET['add'])) {
		$oldusername = 'oldUser';
		return;
	} else {
		$oldusername = $_GET['user'];
	}

    global $doc, $user, $username, $password, $email, $admin, $userqty;
    $docUsers = $doc->getElementsByTagName("user");
	
    foreach($docUsers as $i) {
        $username[$userqty] = $i->getElementsByTagName("username")->item(0)->nodeValue;
        $password[$userqty] = $i->getElementsByTagName("password")->item(0)->nodeValue;
        $email[$userqty] = $i->getElementsByTagName("email")->item(0)->nodeValue;
        $admin[$userqty] = $i->getElementsByTagName("admin")->item(0)->nodeValue;
        if ($user == $_GET['user']) {
            "<tr>
                <div class='edit_item'>
                    <input name='username' placeholder='Username' type='text' style='width:100%' value='$username[$userqty]'/>
                </div>

                <div class='edit_item'>
                    <input name='email' placeholder='E-mail' type='text' style='width:100%' value='$email[$userqty]'/>
                </div>

                <div class='edit_item'>
                    <input name='password' placeholder='Password' type='text' style='width:100%' value='$password[$userqty]'/>
                </div>

                 <div class='edit_item'>
                    <input name='password' placeholder='Confirm Password' type='text' style='width:100%' value='$password[$userqty]'/>
                </div>

                <div class='edit_item'>
                    <input name='admin' placeholder='Yes/No' type='text' style='width:100%' value='$admin[$userqty]'/>
                </div>
            </tr>";
        }

        $userqty++;
    }
}

loadUsers();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/main.css"/>
    <link rel="stylesheet" type="text/css" href="../css/backend_products.css"/>
    <title>
    	Edit a registered user
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script type="text/javascript" src="../scripts/Util.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/Cart.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/Item.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/Sales.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/AbstractComponent.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/Beverage.js">
    	
    </script>
    <script type="text/javascript" src="../scripts/main.js">
    	
    </script>
</head>

<body>
	<?php
    $header = file_get_contents('../common/headerbackend.php');
	echo $header;
    ?>
    <script>
        document.getElementById("helloUser").innerHTML="Hello, <?php echo $_SESSION["currentLogin"][0]; ?>!";
	</script>

	<form type='submit' method='POST' action='../php/editUser.php'>
			<?php
			echo $usersTop;
			foreach ($users as $i) {
				echo $i;
			}
			?>
	</form>
	<br/><br/>

	<?php
    $footer = file_get_contents('../common/footerbackend.php');
    echo $footer;
    ?>
</body>
</html>