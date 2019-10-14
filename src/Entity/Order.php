<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Order {

    public const NEW_ORDER  = 'NEW';

    public const PAID_ORDER = 'PAID';

    private $id;

    private $status;

    private $amount;

    private $products;

    public function __construct() {
        $this->status = self::NEW_ORDER;
        $this->amount = 0;
        $this->products = [];
    }

	/**
	 * @return int
	 */
    public function getId() : int {
        return $this->id;
    }

	/**
	 * @return string
	 */
    public function getStatus() : string {
        return $this->status;
    }

	/**
	 * @param string $status
	 *
	 * @return $this
	 */
    public function setStatus( string $status ) : self {
        $this->status = $status;
        return $this;
    }

	/**
	 * @return int
	 */
    public function getAmount() : int {
        return $this->amount;
    }

	/**
	 * @return array
	 */
    public function getProducts() : array {
        return $this->products;
    }

	/**
	 * @param array $products
	 *
	 * @return $this
	 */
    public function setProducts( array $products ) : self {
        $this->products = $products;

        $this->amount = 0;
        foreach ( $this->products as $product ) {
            $this->amount += $product->getPrice();
        }

        return $this;
    }
}