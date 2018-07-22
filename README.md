# socket
Socket test - PHP/JS

## Use
For use socket, first is necesary run in the server the script\
\> php -q socket.php

If you want quit the socket, you can run these commands\
\> lsof -l +M -i4 | grep :\<port>\
where \<port> is the socket port\
\> kill \<pid>\
where <pid> is the process id of the script
  
Once the script (PHP) socket is running in the server, you can send and receive information via webSockets (JS).
The url must be refer to the same port and with ws scheme. For example: ws://localhost:8090/

## References
- https://techoctave.com/c7/posts/60-simple-long-polling-example-with-javascript-and-jquery
- https://phppot.com/php/simple-php-chat-using-websocket/
- https://medium.com/@cn007b/super-simple-php-websocket-example-ea2cd5893575
- http://php.net/manual/es/book.sockets.php
