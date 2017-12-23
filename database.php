<?php 
date_default_timezone_set('Asia/Yekaterinburg');

define('DB_HOST', 'localhost');
define('DB_NAME', 'cu31997_bot');
define('DB_USER', 'cu31997_bot');
define('DB_PASS', '');
define('DB_CHAR', 'utf8mb4');

function render($tpl,$val = array()){
    extract($val);
    include "views/$tpl.tpl";
}

function prepareDate($date){
    $now = date('Y-m-d');
    $msgTime = date('Y-m-d', $date);
    if($now > $msgTime){
        return date('d.m.y', $date);
    }else{
        return date('H:i', $date);
    }
}

class Database {
    protected $db;
    public $connect;
    public $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct($host=DB_HOST, $dbname=DB_NAME, $charset=DB_CHAR, $user=DB_USER, $pass=DB_PASS){
        $this->connect = TRUE;
        try {
            $this->db = new PDO("mysql:host={$host};dbname={$dbname};charset={$charset}", $user, $pass, $this->opt);
        } catch (PDOException $e) {
            echo $e->getMessage();
        } 
    }
    
    public function disconnect(){
        $this->db = NULL;
        $this->connect = FALSE;
    }

    public function addUser($data, $created){
        try {
            $query = '
                INSERT INTO user (id, is_bot, first_name, last_name, created_at)
                VALUES (:id, :is_bot, :first_name, :last_name, FROM_UNIXTIME(:created_at))
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id'=>$data['id'], 
                ':is_bot'=>$data['is_bot'], 
                ':first_name'=>$data['first_name'], 
                ':last_name'=>$data['last_name'], 
                ':created_at'=>$created
            ]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addChat($data, $created){
        try {
            $query = '
                INSERT INTO chat (id, type, created_at)
                VALUES (:id, :type, FROM_UNIXTIME(:created_at))
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id'=>$data['id'], 
                ':type'=>$data['type'], 
                ':created_at'=>$created
            ]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addMessage($data){
        try {
            $query = '
                INSERT INTO message (chat_id, user_id, date, text)
                VALUES (:chat_id, :user_id, FROM_UNIXTIME(:date), :text)
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':chat_id'=>$data['chat']['id'], 
                ':user_id'=>$data['from']['id'],
                ':date'=>$data['date'],
                ':text'=>$data['text']
            ]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addMessageBot($data){
        try {
            $query = '
                INSERT INTO message (chat_id, user_id, date, text)
                VALUES (:chat_id, :user_id, FROM_UNIXTIME(:date), :text)
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':chat_id'=>$data['chat_id'], 
                ':user_id'=>$data['user_id'],
                ':date'=>time(),
                ':text'=>$data['text']
            ]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getChatList(){
        try {
            $query = '
                SELECT u.id, u.first_name, u.last_name, msg.text, msg.read_msg, chat.favorites, UNIX_TIMESTAMP(msg.date) as date
                FROM user u
                LEFT JOIN chat ON (chat.id = u.id)
                LEFT JOIN (SELECT message.user_id, message.text, message.date, message.chat_id, message.read_msg from message ORDER BY message.date desc) AS msg on msg.user_id = u.id
                where is_bot = 0
                group BY u.id
            ';
            $result = $this->db->query($query)->fetchAll();
            foreach ($result as $value) {
                render('chatItem', $value);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getChatMessage(){
        try {
            $query = '
                SELECT u.id, u.first_name, u.last_name, msg.text, UNIX_TIMESTAMP(msg.date) as date
                FROM user u
                left JOIN message msg on msg.user_id = u.id
                WHERE msg.chat_id = ?
                ORDER BY msg.date DESC;
            ';
            $query_upd = '
                UPDATE message msg
                SET msg.read_msg = 1
                WHERE msg.chat_id = ?
            ';
            $this->db->beginTransaction();

            $stmt_upd = $this->db->prepare($query_upd);
            $stmt_upd->execute([$_GET['chat_id']]);

            $stmt = $this->db->prepare($query);
            $stmt->execute([$_GET['chat_id']]);

            $this->db->commit();

            $result = $stmt->fetchAll();

            foreach ($result as $value) {
                render('chatMessage', $value);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addFavorite(){
        try {
            $query = '
                UPDATE chat 
                SET chat.favorites = 1
                WHERE chat.id = ?
            ';

            $stmt = $this->db->prepare($query);
            $stmt->execute([$_GET['chat_id']]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function removeFavorite(){
        try {
            $query = '
                UPDATE chat 
                SET chat.favorites = 0
                WHERE chat.id = ?
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$_GET['chat_id']]);
            return TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}