<?php

namespace App\models;

class Review extends \App\core\Model {

    public $review_id;
    public $product_id;
    public $buyer_id;
    public $rate;
    public $text_review;

    public function __construct() {
        parent::__construct();
    }

    public function find($review_id) {
        $stmt = self::$connection->prepare("SELECT * FROM review WHERE review_id = :review_id");
        $stmt->execute(['review_id' => $review_id]);
        $stmt->setFetchMode(\PDO::FETCH_GROUP | \PDO::FETCH_CLASS, "App\\models\\Review");
        return $stmt->fetch();
    }
    
    public function getAllReviews() {
        $stmt = self::$connection->query("SELECT * FROM review");
        $stmt->setFetchMode(\PDO::FETCH_GROUP | \PDO::FETCH_CLASS, "App\\models\\Review");
        return $stmt->fetchAll();
    }

    public function insert() {
        $stmt = self::$connection->prepare("INSERT INTO review(product_id, buyer_id, rate, text_review) 
        VALUES (:product_id, :buyer_id, :rate, :text_review)");
        $stmt->execute(['product_id' => $this->product_id, 'buyer_id' =>
            $this->buyer_id, 'rate' => $this->rate, 'text_review' => $this->text_review]);
    }

    public function delete() {
        $stmt = self::$connection->prepare("DELETE from review WHERE review_id=:review_id");
        $stmt->execute(['review_id' => $this->review_id]);
    }

    public function update() {
        $stmt = self::$connection->prepare("UPDATE review SET product_id=:product_id, buyer_id=:buyer_id, rate=:rate, text_review=:text_review");
        $stmt->execute(['product_id' => $this->product_id, 'buyer_id' => $this->buyer_id, 
            'rate' => $this->rate, 'text_review' => $this->text_review]);
    }

}