<?php 
namespace MBSoftware;
require_once 'files.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class mQueue {
    const PENDING = 0;
    const SENDED = 1;
    const REJECT = 2;

    public function __construct($dbSettings = [],$mailSettings=[],$sendLimit = 5){
        $this->mailSettings = $mailSettings;
        $this->sendLimit = $sendLimit;
        try{
            $this->db = new \PDO("mysql:host=".$dbSettings['host'].";dbname=".$dbSettings['dbname'].";charset=utf8",$dbSettings['username'],$dbSettings['password']);
            $query = "CREATE TABLE mqueue (
                id int(11) AUTO_INCREMENT,
                email varchar(255) NOT NULL,
                subject varchar(255) NOT NULL,
                text text,
                isSend int,
                PRIMARY KEY  (id)
                )";
                $this->db->query($query);
        }
        catch(\PDOException $e){
            echo $e->getMessage();
        }
    }


    public function insertQueue($email,$subject,$text)
    {
        $query = $this->db->prepare("insert into mqueue(email,subject,text,isSend) values (?,?,?,?)");
        $status = self::PENDING;
        $query->execute(array($email,$subject,$text,$status));
        return $this;
    }
    
    public function sendQueue($isLast = false,$id = 0)
    {
        if($id != 0){ 
            $data = $this->db->query("select * from mqueue where id = '".$id."'")->fetch(PDO::FETCH_ASSOC);
            $status = $this->sendMail($data['email'],$data['subject'],$data['text']);
            $this->changeStatus($data['id'],(!$status) ? self::REJECT :self::SENDED);
        }
        else if($isLast){ 
            $data = $this->db->query("select * from mqueue where isSend='".self::PENDING."' order by id desc limit 1")->fetch(PDO::FETCH_ASSOC);
            $status = $this->sendMail($data['email'],$data['subject'],$data['text']);
            $this->changeStatus($data['id'],(!$status) ? self::REJECT :self::SENDED);
        
        }
        else 
        {
            $data = $this->db->query("select * from mqueue where isSend='".self::PENDING."' order by id asc limit ".$this->sendLimit)->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $item){
                $status = $this->sendMail($item['email'],$item['subject'],$item['text']);
                $this->changeStatus($item['id'],(!$status) ? self::REJECT :self::SENDED);
            }
        }
    }

    public function changeStatus($id,$status){
        $this->db->query("update mqueue set isSend='".$status."' where id='".$id."'");
    }

    public function sendMail($email,$subject,$text){
        try{
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $this->mailSettings['host'] ?? "";
            $mail->Port = $this->mailSettings['port'] ?? 0;
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailSettings['username'] ?? "";
            $mail->Password = $this->mailSettings['password'] ?? "";
            $mail->setFrom($this->mailSettings['senderMail'] ?? "", $this->mailSettings['senderName'] ?? "");
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->msgHTML($text);
            #$mail->Body = 'Bu öylesine bir yazı';
            if (!$mail->send()) 
            {
                return false;
                //return $mail->ErrorInfo;
            } 
            else 
            {
                return true;
            }
        }
        catch(Exception $e){
            return false;
        }
    
    }

    public function getPending($limit = 0,$order = 'asc')
    {
        $limitK = "";
        if($limit != 0){ $limitK = "limit ".$limit; }
        return  $this->db->query("select * from mqueue where isSend='".self::PENDING."' order by id ".$order." ".$limitK)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReject($limit = 0,$order = 'asc')
    {
        $limitK = "";
        if($limit != 0){ $limitK = "limit ".$limit; }
        return  $this->db->query("select * from mqueue where isSend='".self::REJECT."' order by id ".$order." ".$limitK)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSended($limit = 0,$order = 'asc')
    {
        $limitK = "";
        if($limit != 0){ $limitK = "limit ".$limit; }
        return  $this->db->query("select * from mqueue where isSend='".self::SENDED."' order by id ".$order." ".$limitK)->fetchAll(PDO::FETCH_ASSOC);
    }

}
