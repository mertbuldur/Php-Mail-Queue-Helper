<?php 
require_once 'vendor/autoload.php';
$mQueue  = new MBSoftware\mQueue(
    [
        'host'=>'localhost',
        'dbname'=>'mQueue',
        'username'=>'root',
        'password'=>'123456789'
    ],
    [
        'host'=>'smtp.google.com',
        'port'=>25,
        'username'=>'mbsoftware@gmail.com',
        'password'=>'123456789',
        'senderMail'=>'mbsoftware@gmail.com',
        'senderName'=>'MbSoftware'
    ],
    5
);

/* if you want only add database email content */
#$mQueue->insertQueue("buldurmert@gmail.com","Welcome","Hi");
/* if yout want add database email content and after send mail */
#$mQueue->insertQueue("buldurmert@gmail.com","Welcome","Hi")->sendQueue(true);
/* iTo send a content with a certain id by mail */
#$mQueue->sendQueue(false,6);
