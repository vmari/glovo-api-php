<?php

include 'vendor/autoload.php';

use Glovo\Api;
use Glovo\Model\Order;
use Glovo\Model\Address;

$api = new Api( "125238463972712", "081f8c9680d457a088b4413a62ddf84c" );
// $api->sandbox_mode( true );

$sourceDir = new Address( Address::TYPE_PICKUP, -34.919861, -57.919027, "Diag. 73 1234", "1st floor" );
$destDir = new Address( Address::TYPE_DELIVERY, -34.922945, -57.990177, "Diag. 73 75", "3A" );

$order = new Order();
$order->setDescription( "1 big hammer" );
$order->setAddresses( [$sourceDir, $destDir] );
// $order->setScheduleTime( ( new \DateTime( '+1 hour' ) )->setTime( 19, 0 ) );

$orderEstimate = $api->estimateOrderPrice( $order );

echo "Estimado: {$orderEstimate['total']['amount']}{$orderEstimate['total']['currency']} \n";

$orderInfo = $api->createOrder( $order );

echo "Pedido realizado, ID: {$orderInfo['id']}, state: {$orderInfo['state']} \n";

$order_id = $orderInfo['id'];
$laststate = $orderInfo['state'];

while ($laststate !== Order::STATE_DELIVERED) {
  $info = $api->retrieveOrder( $order_id );

  if ($info['state'] !== $laststate) {
    $laststate = $info['state'];

    if ($laststate === Order::STATE_ACTIVE) {
      $courier_info = $api->getCourierContact( $order_id );
      echo "Pedido aceptado: Courier: {$courier_info['courier']}, Phone: {$courier_info['phone']}\n";
    } else {
      echo "Cambio de estado: $laststate \n";
    }
  }

  if ($laststate === Order::STATE_ACTIVE) {
    $tracking = $api->getOrderTracking( $order_id );
    echo "Pos: {$tracking['lat']},{$tracking['lon']}\n";
  }

  sleep( 45 );
}

echo "Pedido entregado.\n";


