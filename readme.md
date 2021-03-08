Hello, Welcome to MBSoftware  Email Queue Helper Script!

[Support Me For Patreon](https://www.patreon.com/mertbuldur)
|
[Youtube](https://www.youtube.com/c/mertbuldur?sub_confirmation=1)
|
[WebSite](https://mertbuldur.com)


First one installation; 
\
&nbsp;

[Packagist](https://packagist.org/packages/buldurmert/mbqueue)

```
composer require buldurmert/mbqueue
```

1. Enter into folder
2. Run composer install
3. Open cron.php and generate.php
4. Edit the content.
```php
new MBSoftware\mQueue(
    $databaseSettingArray,
    $mailSettingArray,
    $sendLimit = 5
);
```
$databaseSettingArray:
```php
[
    'host'=>'localhost',
    'dbname'=>'databasename',
    'username'=>'root',
    'password'=>'password'
];
```
$mailSettingArray:
```php
[
    'host'=>'mail smtp host',
    'port'=>25,
    'username'=>'mail username',
    'password'=>'mail password',
    'senderMail'=>'mail sender email',
    'senderName'=>'mail sender name'
];
```
$sendLimit:
```
It specifies how many e-mails you will send in the cron run.
```
Example:
```php
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
```
5.Define your cron.php address in your panel to create a cron

6.There are examples in generate.php to create mail content or send mail.

Example:

** if you want only add database email content 
```php
$mQueue->insertQueue("buldurmert@gmail.com","Hello","Welcome to my site");
```

** if yout want add database email content and after send mail 
```php
$mQueue->insertQueue("buldurmert@gmail.com","Hello","Welcome to my site")->sendQueue(true);
```
** To send a content with a certain id by mail 
```php
$mQueue->sendQueue(false,6);
```

** get all pending email content
```php
$mQueue->getPending($limit = 0,$order = 'asc');
```

** get all reject email content
```php
$mQueue->getReject($limit = 0,$order = 'asc');
```

** get all sended email content

```php
$mQueue->getSended($limit = 0,$order = 'asc');
```