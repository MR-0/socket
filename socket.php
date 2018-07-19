<?php
$address = 'localhost';
$port = 8090;
$max_connections = 99;
$delay = 300; // <-- miliseconds


$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, $address, $port);
socket_listen($socket, $max_connections);
// --> Check for ECONNREFUSED in front if max connections is dump

$null = NULL;
$sockets = array($socket);
$clients = array();
$recive = array();

while (true) {
	$new_sockets = $sockets;
	socket_select($new_sockets, $null, $null, 0, $delay*1000);

	// Check if one socket is select
	if (in_array($socket, $new_sockets)) {
		$client = socket_accept($socket);
		$clients[] = $client;
		handshake($client);
	}
	
	// Recive
	foreach ($clients as $client) {
		$bytes = @socket_recv($client, $buf, 1024, MSG_DONTWAIT);
		if ($bytes) {
			$values = unseal($buf); 
			$recive[] = array(
				'date' => time(),
				'values' => json_decode($values)
			);
		}
	}
	
	// Write
	if (count($recive)) {
		foreach ($clients as $i => $client) {
			$content = json_encode($recive);
			$response = chr(129) . chr(strlen($content)) . $content;
			$write = @socket_write($client, $response);
			if ($write === false) {
				socket_close($client);
				array_splice($clients, $i, 1);
			}
		}
		$recive = array();
	}
}

function handshake ($client) {
	$request = socket_read($client, 4096);
	preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $request, $matches);
	$key = base64_encode(pack(
		'H*',
		sha1($matches[1] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
	));
	$headers = "HTTP/1.1 101 Switching Protocols\r\n";
	$headers .= "Upgrade: websocket\r\n";
	$headers .= "Connection: Upgrade\r\n";
	$headers .= "Sec-WebSocket-Version: 13\r\n";
	$headers .= "Sec-WebSocket-Accept: $key\r\n\r\n";
	socket_write($client, $headers, strlen($headers));
}

function unseal($buf) {
	$length = ord($buf[1]) & 127;
	if($length == 126) {
		$masks = substr($buf, 4, 4);
		$data = substr($buf, 8);
	}
	elseif($length == 127) {
		$masks = substr($buf, 10, 4);
		$data = substr($buf, 14);
	}
	else {
		$masks = substr($buf, 2, 4);
		$data = substr($buf, 6);
	}
	$buf = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$buf .= $data[$i] ^ $masks[$i%4];
	}
	return $buf;
}
