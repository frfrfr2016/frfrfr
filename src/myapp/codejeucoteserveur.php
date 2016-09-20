<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class codejeucoteserveur implements MessageComponentInterface {

	public function onOpen(ConnectionInterface $conn) {

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg ) {
		
		$data = json_decode($msg);
		
		$posxjoueur =$data->posxjoueur ;
		
		$posxjoueur  = $posxjoueur+5;    
		
		$data->posxjoueur  = $posxjoueur ;

		$msg = json_encode($data);

		$from->send($msg);
		
	}

	public function onClose(ConnectionInterface $conn) {
		
		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";
		$conn->close();
	}
}
?>