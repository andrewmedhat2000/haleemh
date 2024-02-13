<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{  csrf_token()  }}">
    <title>Document</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
   

  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ac07a30c4658c687afd2', {
      cluster: 'eu'
    });
    var conversationId = 1; // Replace with the desired conversation ID
    var channel = pusher.subscribe('conversation.1');
    channel.bind('NewMessage', function(data) {
      alert(JSON.stringify(data));
    });
    


// Import the functions you need from the SDKs you need



  </script>
</head>
<body>
    <div id="app"></div>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

</body>
</html>
