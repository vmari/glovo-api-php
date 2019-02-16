<?php

namespace Glovo\Model;

class Address implements \JsonSerializable {

  const TYPE_PICKUP = "PICKUP";
  const TYPE_DELIVERY = "DELIVERY";

  /**
   * Latitude of the address.
   *
   * @var float
   */
  private $lat;

  /**
   * Longitude of the address.
   *
   * @var float
   */
  private $lng;

  /**
   * PICKUP or DELIVERY depending on what the courier is expected to do at this address.
   *
   * @var string
   */
  private $type;

  /**
   * Street and number (e.g. 21 Baker St).
   *
   * @var string
   */
  private $label;

  /**
   * Floor / apartment (e.g. 2nd Floor or blue button of the intercom). Optional.
   *
   * @var string
   */
  private $details;

  /**
   * Phone of the sender / recipient at that address. Optional.
   *
   * @var string
   */
  private $contactPhone;

  /**
   * Name of the sender / recipient at that address. Optional.
   *
   * @var string
   */
  private $contactPerson;

  public function __construct( $type, $lat, $lng, $label, $details ) {
    $this->type = $type;
    $this->lat = $lat;
    $this->lng = $lng;
    $this->label = $label;
    $this->details = $details;
  }

  public function jsonSerialize() {
    $data = [];
    $data['type'] = $this->type;
    $data['lat'] = $this->lat;
    $data['lon'] = $this->lng;
    $data['label'] = $this->label;


    if ($this->details !== null) {
      $data['details'] = $this->details;
    }

    if ($this->contactPhone !== null) {
      $data['contactPhone'] = $this->contactPhone;
    }

    if ($this->contactPerson !== null) {
      $data['contactPerson'] = $this->contactPerson;
    }
    return $data;
  }


  /**
   * @return float
   */
  public function getLat() {
    return $this->lat;
  }

  /**
   * @param float $lat
   */
  public function setLat( $lat ) {
    $this->lat = $lat;
  }

  /**
   * @return float
   */
  public function getLng() {
    return $this->lng;
  }

  /**
   * @param float $lng
   */
  public function setLng( $lng ) {
    $this->lng = $lng;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @param string $type
   */
  public function setType( $type ) {
    $this->type = $type;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * @param string $label
   */
  public function setLabel( $label ) {
    $this->label = $label;
  }

  /**
   * @return string
   */
  public function getDetails() {
    return $this->details;
  }

  /**
   * @param string $details
   */
  public function setDetails( $details ) {
    $this->details = $details;
  }

  /**
   * @return string
   */
  public function getContactPhone() {
    return $this->contactPhone;
  }

  /**
   * @param string $contactPhone
   */
  public function setContactPhone( $contactPhone ) {
    $this->contactPhone = $contactPhone;
  }

  /**
   * @return string
   */
  public function getContactPerson() {
    return $this->contactPerson;
  }

  /**
   * @param string $contactPerson
   */
  public function setContactPerson( $contactPerson ) {
    $this->contactPerson = $contactPerson;
  }
}
