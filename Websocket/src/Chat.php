<?php
namespace ChatApp;

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
       
        $this->clients->attach($conn);
        
        print_r($this->clients[$conn]);
        
    }
    
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "onMessage: $msg"; 
        $new_msg =json_decode($msg);
        $type = $new_msg->type;
        $fromUser = $new_msg->from;

        if($type == "new") { // new connection
            //print_r("new : ", $this->activeUsers);
            $this->activeUsers[$fromUser] = $from;

            
            //print_r("old : ",$this->activeUsers);

            if(in_array($from,$this->activeUsers)){
                print_r("existing");
            }
            
        } else {
            $data = $new_msg->data;
            $toUser = $new_msg->to;
            
            echo "to user_id : $toUser";

            echo " msg body : $data";

            try{
                if($this->activeUsers[$toUser]==true)
                {

                    $this->activeUsers[$toUser]->send(json_encode($new_msg));
                }
                else
                {
                    print_r("connection not available");
                }
            }
            catch(Exception $e)
            {
                print_r("err : ",$e->getMessage());
            }  
        }        
    }

    public function onClose(ConnectionInterface $conn)
    {

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        
        unset($this->clientId[$conn->resourceId]);
        
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
    
}
?>