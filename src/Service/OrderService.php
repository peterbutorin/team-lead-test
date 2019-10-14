<?php

namespace App\Service;


use App\Entity\Order;
use App\Entity\Product;
use App\Exception\ValidateException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

class OrderService {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * OrderService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct( EntityManagerInterface $em ) {
        $this->em = $em;

    }

    /**
     * Create new order
     * @param array $products_ids
     * @return int
     */
    public function createOrder( array $products_ids ) : int {
        $products = [];
        foreach ( $products_ids as $products_id ) {
            $products[] = $this->em->find( Product::class, $products_id );
        }
        $order = ( new Order() )->setProducts( $products );

        $this->em->persist( $order );
        $this->em->flush();

        return $order->getId();
    }

    /**
     * Pay order
     * @param int $order_id
     * @param int $amount
     * @throws ValidateException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function payOrder( int $order_id, int $amount ) : void {
        $repo = $this->em->getRepository( Order::class );

        if ( !$order = $repo->findOneBy( [ 'id' => $order_id, 'status' => Order::NEW_ORDER ] ) ) {
            throw new ValidateException( 'Order not found' );
        }

        $getStatusURL  = function ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $http_code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $http_code;
        };
        $httpStatus = $getStatusURL( 'https://ya.ru' );

        if ( 200 !== $httpStatus ) {
            throw new ValidateException( 'Cant pay order, status = ' . $httpStatus );
        }

        $order->setStatus( Order::PAID_ORDER );
        $this->em->flush();
    }
}