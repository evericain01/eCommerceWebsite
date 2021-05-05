<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= BASE ?>/css/style.css" type="text/css">
        <title><?= _("Orders") ?></title>
    </head>
    <body>
        <h1><?= _("All Orders") ?>:</h1>
        <?php
        echo "<div class='homepageLink'><br><h4><a href='" . BASE . "/Buyer/index'>&#8592 " . _("Go Back to Main Page") . "</a></h4></div><br><br><br>";

        if (empty($data["invoice"])) {
            echo "<i>" . _("You have no orders") . ".</i>";
        }
        
        echo "<div class='allOrders'>";

        foreach ($data["invoice"] as $invoice) {
            foreach ($data["products"] as $product) {
                if ($invoice->product_id == $product->product_id) {
                    echo "<table style='width:90%'>";
                    echo "<tr><th>Image</th><th>Name</th><th>Description</th><th>Quantity Bought</th><th>Price</th><th>Total Price</th><th>Seller Name</th><th>Seller Company</th><th>Date Purchased</th><th>Expected Delivery Date</th></tr>";
                    echo "<tr><td><img src='" . BASE . "/uploads/$product->filename' width='80' height='80'/><br><br></td>"; 
                    echo "<td>$product->caption<br></td>";
                    echo "<td>$product->description<br></td>";
                    $quantity = $invoice->total / $product->price;
                    echo "<td>$quantity<br></td>";
                    echo "<td>$product->price CAD<br></td>";
                    echo "<td>$invoice->total CAD<br></td>";
                    foreach ($data["sellers"] as $seller) {
                        if ($invoice->seller_id == $product->seller_id) {
                            echo "<td>$seller->first_name ";
                            echo "$seller->last_name<br></td>";
                            echo "<td>$seller->brand_name<br><br></td>";
                            
                        }
                    }
                }
            }
            echo "<td>$invoice->timestamp<br></td>";
            echo "<td>$invoice->date_of_arrival<br><br></td></tr>";

            echo "</table><br>";
            if ($invoice->status == "Delivered") {
                $exist = false;
                $currentProductReviewID = null;

                foreach ($data["reviews"] as $review) {
                    if ($review->buyer_id == $data['buyer']->buyer_id && $review->product_id == $invoice->product_id) {
                        $exist = true;
                        $currentProductReviewID = $review->review_id;
                        break;
                    }
                }

                echo "<b>" . _("STATUS") . ": <span style='color:#398C0C;text-align:center;'> Delivered </span></b>";
                if ($exist == true) {
                    echo "<br><b><a href='" . BASE . "/Review/edit/$currentProductReviewID'>" . _("Edit Review") . "</a></b><br><br>";
                } else {
                    echo "<br><b><a href='" . BASE . "/Review/add/$invoice->product_id'>" . _("Leave a Review") . "?</a></b><br><br><br>";
                }
            } else {
                echo "<b>" . _("STATUS") . ": <span style='color:#C77800;text-align:center;'> " . _("In Transit") . " </b></span>";
                echo "<a href='" . BASE . "/Invoice/updateStatus/$invoice->invoice_id'>" . _("Recieved") . "?</a><br><br>";
            }
            echo "<hr style='width:100%;text-align:left;margin-left:0'><br>";
        }
        
        echo "</div>";
        ?>
    </body>
</html>
