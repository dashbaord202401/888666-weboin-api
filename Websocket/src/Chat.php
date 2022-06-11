<?php
namespace ChatApp;
// include("../db/chat_table.php");
// require (__DIR__."/../db/active_users.php");
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $activeUsers=array();
    
    function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "Server Started \n";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        echo "New Connection : ID : ({$conn->resourceId})\n";
        // $key = (object)['key' => 'User12345'];
        $this->clients->attach($conn);
        // $this->clientId[$conn->resourceId]= $conn->resourceId;
        // $this->activeUsers[$conn->resourceId]= $conn->resourceId;
        // print_r($this->clientId);

        // array_push($this->clientId, $conn->resourceId);
        // print_r($key->key);
        print_r($this->clients[$conn]);
        // echo implode("",$this->clientId);
    }
    
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "onMessage: $msg"; 
        $new_msg =json_decode($msg);
        $type = $new_msg->type;
        $fromUser = $new_msg->from;
        if($type == "new") { // new connection
            // echo "inside new: $from->resourceId";
            // $key = (object)['key' => $fromUser];
            // $this->clients->detach($from);    
            // $this->clients->attach($key, $from);    
            $this->activeUsers[$fromUser] = $from;
            // print_r($this->clients[$from]);
            // print_r($this->clients[$from]->$key);
            // foreach ($this->clients as $client) 
            // {
            //     // echo "new Recourse - {$client->$key} \n";
            //     echo "yes";
            // }
            // foreach ($this->clients as $keys => $value) 
            // {
            //     // echo "key -> $keys";
            //     var_dump($key);
            //     var_dump($value);
            //     // echo "value -> $value";
            // }
            // working here but in else telling no object
            // echo "Sending connection message from {$this->clients[$key]->resourceId}";
                // echo "Sending {$this->clients[$from]} \n";
                // $to_msg = (object) [
                //     "data" => $new_msg->data,
                //     "from" => $fromUser,
                // ];
                // $client->send(json_encode($to_msg));
                // $this->clients[$key]->send(json_encode($to_msg));
        } else {
            $data = $new_msg->data;
            $toUser = $new_msg->to;
            // if($conn) {
            //     $sql = "INSERT INTO chats (from_id, to_id, msg) values ($fromUser, $toUser, $data)";
            //     if ($conn->query($sql) === TRUE) {
            //       echo "New record created successfully";
            //     } else {
            //       echo "Error: " . $sql . "<br>" . $conn->error;
            //     }
            // }else {
            // }
            echo "to: $toUser";
            $to_msg = (object) [
                "data" => $data,
                "from" => $fromUser,
            ];
            // echo "data: $msg"; 
            echo " msg body : $data";
            // echo "$this->activeUsers[$toUser]->resourceId";
            $this->activeUsers[$toUser]->send(json_encode($to_msg));

            // $active_users[$fromUser] = $from;

            // foreach ($this->clients as $client) 
            // {
            //     echo "\n Sending {$this->clients[$client]} \n";
            //     // if ($client != $from)
            //     // {
            //     //     $client->send(json_encode($to_msg));
            //     // }
            // }
            // $keys = (object)['key' => $toUser];
            // var_dump($keys);
            // echo "Sending connection message from {$this->clients[$keys]}";
                // echo "Sending {$this->clients[$from]} \n";
                // $to_msg = (object) [
                //     "data" => $new_msg->data,
                //     "from" => $fromUser,
                // ];
                // // $client->send(json_encode($to_msg));
                // $this->clients[$key]->send(json_encode($to_msg));
        }        
    }

    public function onClose(ConnectionInterface $conn)
    {

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        // unset($this->clientId[$conn->resourceId]);
        unset($this->clientId[$conn->resourceId]);
        // print_r($this->clientId);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
    
}
?>