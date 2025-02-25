<?php

require_once("../classes/MailManager.php");
require_once("../classes/Database.php");
require_once("../db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    echo "Host: " . $db->getHost() . "\n";
    echo "Username: " . $db->getUsername() . "\n";
    echo "Password: " . $db->getPassword() . "\n";
    echo "DbName: " . $db->getDbname() . "\n";

    try{
        $mm = new MailManager($db->getHost(), $db->getUsername(), $db->getPassword(), $db->getDbname());

        $mm->set_subject($subject);
        $mm->add_recipient($recipient);
        $mm->set_body($body);

        $mm->send();

        echo "Should of been success full...";
    }
    catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>

