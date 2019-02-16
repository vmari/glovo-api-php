<?php

namespace Glovo;

use Glovo\Model\Order;

class Api {
  const VERSION = "0.0.1";

  private $apiKey;
  private $apiSecret;
  private $sandbox = false;

  function __construct( $apiKey, $apiSecret ) {
    $this->apiKey = $apiKey;
    $this->apiSecret = $apiSecret;
  }

  private function exec( $method, $uri, $data = [] ) {
    return Client::exec( [
      "auth" => [
        "apiKey" => $this->apiKey,
        "apiSecret" => $this->apiSecret
      ],
      "sandbox" => $this->sandbox,
      "method" => $method,
      "uri" => $uri,
      "data" => $data
    ] );
  }

  public function sandbox_mode( $enable = null ) {
    if (!is_null( $enable )) {
      $this->sandbox = $enable === true;
    }

    return $this->sandbox;
  }

  /**
   * Returns the characteristics of our working areas. Use this data to check for valid pickup and
   * delivery locations and times in your side. A way of doing this can be found in
   * com.google.maps.android.PolyUtil::containsLocation
   *
   * We recommend you to use aggressive caching for the results of this endpoint in order to
   * avoid unnecessary server-to-server traffic that could make you activate rate limiting.
   *
   * @return WorkingArea[]
   */
  public function getWorkingAreas() {
  }

  /**
   * Provide a price estimation for an order.
   * The response amount will always be in the minor of the currency (e.g. cents for EUR).
   *
   * Example return:
   *
   * "total": {
   *     "amount": 590,
   *     "currency": "EUR"
   * }
   * @return array
   */
  public function estimateOrderPrice( Order $order ) {
    return $this->exec( "POST", "/orders/estimate", $order );
  }

  /**
   * Create a scheduled or immediate order. If you want to schedule an order, provide a scheduleTime.
   * If you don't, it'll be immediately activated for deliver.
   */
  public function createOrder( Order $order ) {
    return $this->exec( "POST", "/orders", $order );
  }

  /**
   * Retrieve information about a single order.
   *
   * @return array
   */
  public function retrieveOrder( $id ) {
    return $this->exec( "GET", "/orders/$id" );
  }

  /**
   * Return the position (latitude, longitude) of the courier.
   *
   * Example return:
   *
   * {
   *    "lat": 0.1234,
   *    "lon": 0.1234
   * }
   * @return array
   */
  public function getOrderTracking( $id ) {
    return $this->exec( "GET", "/orders/$id/tracking" );
  }

  /**
   * Name and contact phone of the courier if the order is active. Error if the order is not active.
   *
   * Example return:
   * {
   *     "courier": "Alfonso",
   *     "phone": "+34666123123"
   * }
   *
   * @return array
   */
  public function getCourierContact( $id ) {
    return $this->exec( "GET", "/orders/$id/courier-contact" );
  }

  /**
   * Retrieve a list of orders created after or during from and before to timestamps.
   * Limits or alternative pagination means are yet to be defined.
   *
   * @return array
   */
  public function getOrders( \DateTime $from, \DateTime $to ) {
    return $this->exec( "GET", "/orders?from={$from->getTimestamp()}&to={$to->getTimestamp()}" );
  }

  /**
   * Cancel a scheduled order. Active orders cannot be canceled.
   *
   * @return boolean
   */
  public function cancelOrder( $id ) {
    try {
      $this->exec( "POST", "/orders/$id/cancel" );
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
}
