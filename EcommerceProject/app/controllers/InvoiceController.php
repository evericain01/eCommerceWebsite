<?php

namespace App\controllers;

class InvoiceController extends \App\core\Controller {

    function index() {
        function index() {
            if (isset($_POST["action"])) {
                // $keyword = $_POST["keyword"];
                // $profiles = new \App\models\Profile();
                // $profiles = $profiles->searchForUser($keyword);
                // if ($keyword == "") {
                //     echo "INVALID: Please input a first, middle or last name.<br><br>";
                //     echo "<a href='" . BASE . "/Profile/index/'>&#8592 Go back</a>";
                // } else {
                //     $this->view('Profile/listOfProfiles', ['keyword' => $keyword, 'profiles' => $profiles]);
                // }
            } else {
                $buyer = new \App\models\Buyer();
                $buyer = $buyer->findUserId($_SESSION['user_id']);

                $invoices = new \App\models\Invoice();
                $invoices = $invoices->getAllInvoiceOfBuyer($buyer->buyer_id);

                $sellers = new \App\models\Seller();
                $sellers = $sellers->getAllSellers();

                $products = new \App\models\Product();
                $products = $products->getAllProducts();
    
                $this->view('Buyer/buyerMainPage', ['products' => $products, 'buyer' => $buyer, 'sellers' => $sellers,
                'invoices' => $invoices]);
            }
        }
    
    }

    function add($product_id) {
        if (isset($_POST["action"])) {
            $invoice = new \App\models\Invoice();
            $buyer = new \App\models\Buyer();
            $product = new \App\models\Product();
            $seller = new \App\models\Seller();

            $product = $product->find($product_id);
            $seller = $seller->find($product->product_id);
            $buyer = $buyer->findUserId($_SESSION['user_id']);

            $invoice->buyer_id = $buyer->buyer_id;
            $invoice->seller_id = $seller->seller_id;
            $invoice->product_id = $product->product_id;

            $invoice->insert();
            // header("location:" . BASE . "/Buyer/index/$buyer->buyer_id");
        } else {
            // $invoice = new \App\models\Invoice();
            // $invoice = $invoice->findUserId($_SESSION['user_id']);
            // $this->view('Buyer/createBuyerProfile', $buyer);
        }
    }

    function checkStatus($invoice_id) {
        
    }

    // function edit($profile_id) {
    //     $profile = new \App\models\Profile();
    //     $profile = $profile->find($profile_id);
    //     $user_id = $profile->user_id;

    //     if (isset($_POST["action"])) {
    //         $profile->profile_id = $profile_id;
    //         $profile->user_id = $user_id;
    //         $profile->first_name = $_POST["first_name"];
    //         $profile->middle_name = $_POST["middle_name"];
    //         $profile->last_name = $_POST["last_name"];

    //         $profile->update();
    //         header("location:" . BASE . "/Profile/index/$profile->profile_id");
    //     } else {
    //         $profile = new \App\models\Profile();
    //         $profile = $profile->find($profile_id);

    //         $user = new \App\models\User();
    //         $user = $user->find($_SESSION['username']);
    //         $this->view('Profile/editProfile', ['profile' => $profile, 'user' => $user]);
    //     }
    // }

    // function otherProfile($profile_id) {
    //     $friendProfile = new \App\models\Profile();
    //     $friendProfile = $friendProfile->find($profile_id);

    //     $otherUserProfile = new \App\models\Profile();
    //     $otherUserProfile = $otherUserProfile->getAllProfiles();

    //     $messages = new \App\models\Message();
    //     $messages = $messages->getAllPublicMessages($friendProfile->profile_id);

    //     $otherPictures = new \App\models\Picture();
    //     $otherPictures = $otherPictures->getAllPictures($friendProfile->profile_id);

    //     $picture_likes = new \App\models\PictureLike();
    //     $picture_likes = $picture_likes->findAllLikes();

    //     $this->view('Profile/otherWall', ['messages' => $messages, 'friendProfile' =>
    //         $friendProfile, 'otherProfile' => $otherUserProfile, 'otherPictures' =>
    //         $otherPictures, 'picture_likes' => $picture_likes]);
    // }

}

?>