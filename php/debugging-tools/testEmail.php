<?php

require_once("../classes/MailManager.php");
require_once("../classes/Database.php");
require_once("../db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    echo "Host: " . $db->getHost() . "\r\n". "<br>";
    echo "Username: " . $db->getUsername() . "\r\n". "<br>";
    echo "Password: " . $db->getPassword() . "\r\n". "<br>";
    echo "DbName: " . $db->getDbname() . "\r\n". "<br>";
    echo "recipient: " . $recipient . "\r\n". "<br>";
    echo "subject: " . $subject . "\r\n". "<br>";
    echo "body: " . $body. "\r\n";

    try{
        $mm = new MailManager($db->getHost(), $db->getUsername(), $db->getPassword(), $db->getDbname());

        $mm->set_subject($subject);
        $mm->add_recipient($recipient);
        $mm->set_body($body);

        $mm->send();

        echo "Should of been successful...";
    }
    catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

?>

