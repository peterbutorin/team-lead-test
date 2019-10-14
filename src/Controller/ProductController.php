<?php

namespace App\Controller;

use App\Entity\Product;
use App\Http\Api;
use App\Service\ProductService;

class ProductController extends AbstractController {

    /**
     * Show all products
     * @return Api
     */
    public function index() {
        $repo = $this->em->getRepository(Product::class);

        return Api::success( $repo->getAll() );
    }
}