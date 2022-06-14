<?php
//include auth_session.php file for authetication
//include("auth_session.php");
//include("db/active_users.php");


?>
<!DOCTYPE html>
<html>
  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <style>
      input,
      button,
      p {
        padding: 10px;
      }
    </style>
  </head>
  <body>
    <!-- <input type="text" id="name" autocomplete="off" />
    <button onclick="connectMessage()">Connect</button>
    <br /> -->
    <input type="text" id="message" autocomplete="off" />
    <button onclick="transmitMessage()">Send</button>

    <div>
      <h2> <?php echo $_SESSION['username']; ?></h2>
      <ul id="messages"></ul>
    </div>

    <p><a href="logout.php">Logout</a></p>
    
    
  </body>


  <script>
      // var resp = prompt("Enter Your Email");
      var resp =  "<?php echo $_SESSION['username']; ?>"
      console.log("Resp>>>>", resp);

      // Create a new WebSocket.
      var socket = new WebSocket("ws://localhost:2222/");

      // Define the message
      var message = document.getElementById("message").value;

      // Define the name
      var name = document.getElementById("name");

      var to = "bommi";
      function transmitMessage() {
        message = document.getElementById("message").value;
        let data = {
          from : resp,
          data: message,
          to: to,
          type: "message",
          
        };
        socket.send(JSON.stringify(data));
      };

      socket.onopen = function (ev) {
        let data = {
          from : resp,
          to: to,
          data: 'onOpen',
          type: "new",
        };
        socket.send(JSON.stringify(data));
        console.log("Connected to server ");
      };

      socket.onmessage = function (e) {
        let RecivedData = JSON.parse(e.data);
        console.log("RecivedData>>>", RecivedData)
        $('#messages').append(`<li> <strong>${RecivedData.from} :</strong> ${RecivedData.data}</li>`);
        // console.log(e.data);
      };
    </script>
</html>
