Processing...<br/><br/>
<?php
session_start();


if (isset($_POST['toDelete'])) {
    $xml = simplexml_load_file("../data.xml");
    foreach ($xml->users->user as $i) {
        if ($i->user == $_POST['toDelete']) {
            $currentuser = $i;
        }
    }
    unset($currentuser[0]);

    $doc = new DOMDocument(1.0);
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;
    $doc->loadXML($xml->asXML());
    $doc->save("../data.xml");

    header("Location: ../backend/userlist.php");
    exit();
}

if (isset($_POST['addnew'])) {
    $new = true;
} else {
    $new = false;
}

if ($_POST['user1'] == "" or $_POST['username1'] == "" or $_POST['password1'] == "" or $_POST['email1'] == "" or $_POST['admin1'] == "") {

    $failed =
    "<form name='failed' id='failed' method='POST' action='../backend/userlist.php' type='submit'><input id=failed name='failed' value='failed'/></form>
    <script>document.getElementById(\"failed\").submit();</script>";
    echo $failed;
    exit();
}

$xml = simplexml_load_file("../data.xml");

if ($new) {
    $xml->users->addChild('user');
    foreach ($xml->users->user as $i) {
        if ($i->user == "") {
            $currentuser = $i;
        }
    }

    $t = 1;
    $currentuser->addChild('username', $_POST['username'.$t]);
    $currentuser->addChild('password', $_POST['password'.$t]);
    $currentuser->addChild('email', $_POST['email'.$t]);
    $currentuser->addChild('admin', $_POST['admin'.$t]);
} 

else {

    foreach ($xml->users->user as $i) {
        if (checkUser($i->user)) {
            $currentuser = $i;
        }
    }
    echo $currentuser;

    $currentuser->addChild('username', $_POST['username'.$user]);
    $currentuser->addChild('password', $_POST['password'.$user]);
    $currentuser->addChild('email', $_POST['email'.$user]);
    $currentuser->addChild('admin', $_POST['admin'.$user]);
    }

function checkUser($userToCheck) {
    if ($userToCheck == $_POST['oldusername']) {
        return true;
    } else {
        return false;
    }
}

$doc = new DOMDocument(1.0);
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->loadXML($xml->asXML());
$doc->save("../data.xml");

header("Location: ../backend/userlist.php");
?>