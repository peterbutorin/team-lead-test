<?php

namespace App\Controller;

use App\Exception\InvalidInputParamException;
use App\Exception\ValidateException;
use App\Http\Api;
use App\Service\OrderService;

class OrderController extends AbstractController {
    /**
     * Create order
     * @return Api
     * @throws InvalidInputParamException
     * @throws ValidateException
     */
    public function create() {
        if ( !$products_ids = $this->request->get( 'products' ) ) {
            throw new InvalidInputParamException( 'products' );
        }
        if ( !is_array( $products_ids ) ) {
            throw new ValidateException( 'Empty product list' );
        }
        foreach ( $products_ids as $product_id ) {
            if ( !$product_id || (int)$product_id <= 0 ) {
                throw new ValidateException( 'Product id must be more than 0' );
            }
        }

        $service = new OrderService( $this->em );
        $orderId = $service->createOrder( $products_ids );

        return Api::success( [ 'orderId' => $orderId ], 201 );
    }

    /**
     * Payment order
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws InvalidInputParamException
     * @throws ValidateException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function pay() {
        if ( !$order_id = $this->request->get( 'order_id' ) ) {
            throw new InvalidInputParamException( 'order_id' );
        }
        if ( !$amount   = $this->request->get( 'amount' ) ) {
            throw new InvalidInputParamException( 'amount' );
        }

        $service = new OrderService( $this->em );
        $service->payOrder( $order_id, $amount );

        return Api::success();
    }
}