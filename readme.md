Hello, Welcome to MBSoftware Email Queue Helper Script!
First one installation;
1. Enter into folder
2. Run composer install or Upload the file with Composer installed
3. Open cron.php and generate.php
4. Edit the content.
new MBSoftware\mQueue(
    $databaseSettingArray,
    $mailSettingArray,
    $sendLimit = 5
);
$databaseSettingArray:
[
    'host'=>'localhost',
    'dbname'=>'databasename',
    'username'=>'root',
    'password'=>'password'
];
$mailSettingArray:
[
    'host'=>'mail smtp host',
    'port'=>25,
    'username'=>'mail username',
    'password'=>'mail password',
    'senderMail'=>'mail sender email',
    'senderName'=>'mail sender name'
];

$sendLimit:
It specifies how many e-mails you will send in the cron run.

Example:
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
5.Define your cron.php address in your panel to create a cron
6.There are examples in generate.php to create mail content or send mail.
Example:

** if you want only add database email content 
$mQueue->insertQueue("buldurmert@gmail.com","Hello","Welcome to my site");

** if yout want add database email content and after send mail 
$mQueue->insertQueue("buldurmert@gmail.com","Hello","Welcome to my site")->sendQueue(true);

** To send a content with a certain id by mail 
$mQueue->sendQueue(false,6);

** get all pending email content
$mQueue->getPending($limit = 0,$order = 'asc');

** get all reject email content
$mQueue->getReject($limit = 0,$order = 'asc');

** get all sended email content
$mQueue->getSended($limit = 0,$order = 'asc');
