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
    
$mQueue->sendQueue(false);
