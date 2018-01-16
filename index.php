<?php

error_reporting(E_ALL);
date_default_timezone_set('Europe/Copenhagen');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$c = new \Slim\Container();
$c['foundHandler'] = function() {return new \Slim\Handlers\Strategies\RequestResponseArgs();};

$app = new \Slim\App($c);

    // //GETTING ALL PRODUCTS
	// $app->get('/products', function () use ($app) {
	// 	require_once 'dbconnect.php';
    //     $query = "SELECT id, name, price*100 AS price, available FROM products WHERE is_deleted=0";
	// 	$result = $mysqli->query($query);

	// 	while ($row = $result->fetch_assoc()){
	// 		$prod_id = (int) $row['id'];
	// 		$prod_name = $row['name'];
	// 		$prod_price = (int) $row['price'];
	// 		if ((int) $row['available'] == 1) {
	// 			$available = true;
	// 		} else {
	// 			$available = false;
	// 		}
			
	// 		$data[] = array(
	// 			'id' => $prod_id,
	// 			'name' => $prod_name,
	// 			'price' => $prod_price,
	// 			'available' => $available
	// 		);
	// 	}

	// 	if (!isset($data)) {
	// 		$data = [];
	// 	}
	// 	$this->response->withHeader('Content-type', 'application/json');
	// 	return $this->response->withJson(array('products' => $data));
    //     $mysqli->close();	
	// });

    //CREATE NEW ORDER
	$app->get('/login', function ($request, $response) use ($app) {
		require_once 'dbconnect.php';
		
		echo 'login';
        
        // if (!isBarEnabled($mysqli)) {
        // 	$error = "Bar is not accepting orders online!";
        // 	return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
        // }

		// $json = $request->getBody();
    	// $data = json_decode($json, true);

        // if (!isset($data)) {
        // 	$error = "There is mistake in your request body!";
        // 	return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
        // }

        // if (!isset($data['items']) || sizeof($data['items']) == 0) {
        // 	$error = "There are no items in the order!";
		// 	return $this->response->withStatus(403)->withHeader('Content-type', 'application/json')->withJson(array('error' => $error));
        // }

    	

		// $this->response->withHeader('Content-type', 'application/json');
		// return $this->response->withJson(array('order' => make_response($order_id,$mysqli)));	
		// $mysqli->close();
	});

//     //UPDATING PAYMENT_ID & STATUS
// 	$app->put('/orders/{order_id}', function ($request, $response,$order_id) use ($app) {

//         require_once 'dbconnect.php';

// 		$json = $request->getBody();
//     	$data = json_decode($json, true);
    	
//     	//SET PAYMENT_ID TO THE ORDER TABLE AND UPDATE ORDER STATUS
//     	$query = "UPDATE orders SET payment_id = ".$data['payment_id'].", state='PENDING' WHERE id = ".$order_id."";
//     	$mysqli->query($query);

//     	$this->response->withHeader('Content-type', 'application/json');
// 		return $this->response->withJson(array('order' => make_response($order_id,$mysqli)));	
// 		$mysqli->close();
// 	});

//     //GETTING ORDERS BY FETCH_ID
//     $app->get('/orders', function () use ($app) {
//         if (isset($_GET['order'])){
//             $orders = $_GET['order'];

//             require_once 'dbconnect.php';
//             $query = "SELECT id, fetch_id FROM orders";
//             $result = $mysqli->query($query);

//             while ($row = $result->fetch_assoc()){
//                 $ord[$row['fetch_id']] = $row['id'];
//             }

//             foreach ($orders as $order) {
//                 $answer[] = make_response($ord[$order],$mysqli);
//             }

//             $this->response->withHeader('Content-type', 'application/json');
//             return $this->response->withJson(array('orders' => $answer));   
//             $mysqli->close();
//         }        
//     });

// $app->run();

// //GENERATES FETCH_ID
// function gen_uuid() {
//     return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
//         // 32 bits for "time_low"
//         mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

//         // 16 bits for "time_mid"
//         mt_rand( 0, 0xffff ),

//         // 16 bits for "time_hi_and_version",
//         // four most significant bits holds version number 4
//         mt_rand( 0, 0x0fff ) | 0x4000,

//         // 16 bits, 8 bits for "clk_seq_hi_res",
//         // 8 bits for "clk_seq_low",
//         // two most significant bits holds zero and one for variant DCE1.1
//         mt_rand( 0, 0x3fff ) | 0x8000,

//         // 48 bits for "node"
//         mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
//     );
// }

// //CREATING RESPOSNE FOR ONE ORDER
// function make_response($order_id,$mysqli){

//     //ALL FROM ORDERS
// 	$query = "SELECT * FROM orders WHERE id = ".$order_id."";
// 	$result = $mysqli->query($query);
	
// 	$order = $result->fetch_assoc();
// 	$order['id'] = (int) $order['id'];
// 	$order['total_price'] = (int) $order['total_price'];

// 	//ALL FROM ORDER LINES
// 	$query = "SELECT * FROM order_lines WHERE order_id = ".$order_id."";
// 	$result = $mysqli->query($query);
	
// 	while ($row = $result->fetch_assoc()){
// 		$query = "SELECT * FROM products WHERE id = ".$row['product_id']."";
// 		$resultx = $mysqli->query($query);
// 		$prd = $resultx->fetch_assoc();
// 		$prd['id']=(int) $prd['id'];
// 		$prd['price'] = $prd['price']*100;
// 		if ((int) $prd['available'] == 1) {
// 			$prd['available'] = true;
// 		} else {
// 			$prd['available'] = false;
// 		}

// 		$items[] = array(
// 			'id' => (int) $row['id'],
// 			'product' => $prd,
// 			'order_id' => (int)$row['order_id'],
// 			'total_price' => (int)$row['total_price'],
// 			'quantity' => (int)$row['quantity']
// 		);
// 	}	

// 	$order['items'] = $items;
// 	return $order;
// }

// function orderNumber($mysqli){
// 	$query = "SELECT order_number FROM settings WHERE 1";
// 	$result = $mysqli->query($query);
// 	$row = $result->fetch_assoc();
// 	$order_number = $row['order_number'];

// 	if ($order_number == 500) {
// 		$next_number = 1;
// 	} else {
// 		$next_number = $order_number + 1;
// 	}

// 	$query = "UPDATE settings SET order_number=".$next_number."";
// 	$mysqli->query($query);
// 	return $order_number;
// }

// function isBarEnabled($mysqli){
// 	$query = "SELECT is_enabled FROM settings WHERE 1";
// 	$result = $mysqli->query($query);
// 	$row = $result->fetch_assoc();
// 	$is_enabled = $row['is_enabled'];

// 	if ($is_enabled == 1) {
// 		return true;
// 	} else {
// 		return false;
// 	}
// }
?>