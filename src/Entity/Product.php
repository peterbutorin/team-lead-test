<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Product implements \JsonSerializable {

    private $id;

    private $name;

    private $price;

	/**
	 * @return int
	 */
    public function getId() : int {
        return $this->id;
    }

	/**
	 * @return string
	 */
    public function getName() : string {
        return $this->name;
    }

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
    public function setName( string $name ) : self {
        $this->name = $name;
        return $this;
    }

	/**
	 * @return int
	 */
    public function getPrice() : int {
        return $this->price;
    }

	/**
	 * @param int $price
	 *
	 * @return $this
	 */
    public function setPrice( int $price ) : self {
        $this->price = $price;
        return $this;
    }

	/**
	 * @return array|mixed
	 */
    public function jsonSerialize() {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => $this->price,
        ];
    }
}