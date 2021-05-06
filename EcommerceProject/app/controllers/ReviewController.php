<?php

namespace App\controllers;

class ReviewController extends \App\core\Controller {

    function index($product_id) {
        $buyers = new \App\models\Buyer();
        $buyers = $buyers->getAllBuyers();
        
        $product = new \App\models\Product();
        $product = $product->find($product_id);

        $review = new \App\models\Review();
        $review = $review->getReviewsOfProduct($product_id);

        $this->view('Review/viewReviews', ['product' => $product, 'reviews' => $review, 'buyers' => $buyers]);
    }

    function reviewSellerIndex($product_id) {
        $seller = new \App\models\Seller();
        $seller = $seller->findUserId($_SESSION['user_id']);
        $seller = $seller->find($seller->seller_id);

        $products = new \App\models\Product();
        $products = $products->getAllProducts();

        $review = new \App\models\Review();
        $review = $review->getReviewsOfProduct($product_id);

        $buyer = new \App\models\Buyer();
        $buyer = $buyer->getAllBuyers();

        $this->view('Review/viewReviewsForSeller', ['products' => $products,
            'reviews' => $review, 'seller' => $seller, 'buyer' => $buyer]);
    }

    function add($product_id) {
        if (isset($_POST["action"])) {
            $review = new \App\models\Review();

            $buyer = new \App\models\Buyer();
            $buyer = $buyer->findUserId($_SESSION['user_id']);

            $buyerReviews = new \App\models\Review();
            $buyerReviews = $buyerReviews->getAllReviewsOfBuyer($buyer->buyer_id);

            $review->buyer_id = $buyer->buyer_id;
            $review->product_id = $product_id;
            $review->rate = $_POST["rate"];
            $review->text_review = $_POST["text_review"];
            $review->insert();

            $sellers = new \App\models\Seller();
            $sellers = $sellers->getAllSellers();

            $products = new \App\models\Product();
            $products = $products->getAllProducts();

            $invoice = new \App\models\Invoice();
            $invoice = $invoice->getAllInvoiceOfBuyer($buyer->buyer_id);

//            $this->view('Invoice/listAllOrders', ['products' => $products, 'sellers' => $sellers,
//                'invoice' => $invoice, 'reviews' => $buyerReviews]);
            
            header("location:" . BASE . "/Invoice/index");
        } else {
            $buyer = new \App\models\Buyer();
            $buyer = $buyer->findUserId($_SESSION['user_id']);
            $this->view('Review/addReview');
        }
        
        
    }

    function edit($review_id) {
        if (isset($_POST["action"])) {
            $review = new \App\models\Review();
            $review = $review->find($review_id);

            $buyerReviews = new \App\models\Review();

            $buyer = new \App\models\Buyer();
            $buyer = $buyer->findUserId($_SESSION['user_id']);

            $buyerReviews = $buyerReviews->getAllReviewsOfBuyer($buyer->buyer_id);

            $review->rate = $_POST["rate"];
            $review->text_review = $_POST["text_review"];
            $review->update();

            $sellers = new \App\models\Seller();
            $sellers = $sellers->getAllSellers();

            $products = new \App\models\Product();
            $products = $products->getAllProducts();

            $invoice = new \App\models\Invoice();
            $invoice = $invoice->getAllInvoiceOfBuyer($buyer->buyer_id);

            $this->view('Invoice/listAllOrders', ['products' => $products,
                'sellers' => $sellers, 'invoice' => $invoice, 'buyer' => $buyer, 'reviews' => $buyerReviews]);
        } else {
            $review = new \App\models\Review();
            $review = $review->find($review_id);
            $this->view('Review/editReview', $review);
        }
    }

}

?>