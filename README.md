# socket
Socket test - PHP/JS

## Use
For use socket, first is necesary run in the server the script\
\> php -q socket.php\
To run the socket.php independent of the terminal window, you can run first screen:\
\> screen\
And the run the script:\
\> php socket.php\
To check running screen scripts:\
\> screen -ls\
To quit screen session:\
\> screen -X -S \<session \#\> quit\

Or use these:\
\> nohup php -q socket.php &\
And check if its works with:\
\> top

If you want quit the socket, you can run these commands\
\> lsof -l +M -i4 | grep :\<port>\
where \<port> is the socket port\
\> kill \<pid>\
where <pid> is the process id of the script
  
Once the script (PHP) socket is running in the server, you can send and receive information via webSockets (JS).
The url must be refer to the same port and with ws scheme. For example: ws://localhost:8090/

### Check server state
For control check the ports avaible in the server\
\> nmap server.name.com\
And...\
\> telnet server.name.com 8090\
Via SSH to check if you can connect to a specific port in the server

### Via proxy server
If you run the socket in a proxy, you must define a route and set the script as a index in that route, because you must match the proxy and socket headerto handshake whit the client.

### Client side rout
The route is compound by:
- protocol -> ws://
- host     -> your.host
- port     -> :8888
- path     -> /path\
The protocol can be 'ws' or 'wss' -for ssl connection-, the host can be literaly or numeric, refer to a ip; the port generaly must be set above 8000. At last, the path can be set or not, depending the type of server you have. If its a proxy, you must set the port redirection, isolate it from the rest of the site. And, was i say early, you must set the script name as a index. In a regular server, you free to setup as you want, even in the same directory, and target the exact url to the script. 

## References
- https://techoctave.com/c7/posts/60-simple-long-polling-example-with-javascript-and-jquery
- https://phppot.com/php/simple-php-chat-using-websocket/
- https://medium.com/@cn007b/super-simple-php-websocket-example-ea2cd5893575
- http://php.net/manual/es/book.sockets.php
- https://help.dreamhost.com/hc/en-us/articles/217955787-Proxy-Server
- http://www.forosdelweb.com/f18/aporte-aplicacion-para-entender-sockets-php-951089/
- http://php.net/manual/es/sockets.examples.php
- https://stackoverflow.com/questions/612115/how-do-i-run-a-php-script-through-ssh
- https://www.htmlgoodies.com/html5/other/create-a-bi-directional-connection-to-a-php-server-using-html5-websockets.html#fbid=QqpDVi8FqD9
- https://stackoverflow.com/questions/6398887/using-php-with-socket-io/25232508

## Use instead
- https://github.com/walkor/phpsocket.io
- http://socketo.me/
