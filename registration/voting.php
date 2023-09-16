<?php
// Initialize session or user-specific data storage
session_start();

// Define an array to store user's voted products
if (!isset($_SESSION['user_votes'])) {
    $_SESSION['user_votes'] = [];
}

// Define an array to store the product vote counts
if (!isset($product_votes)) {
    $product_votes = [
        'product1' => 0,
        'product2' => 0,
        'product3' => 0,
    ];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitVote"])) {
    // Check if the user has reached the maximum vote limit (5 votes)
    if (count($_SESSION['user_votes']) >= 5) {
        echo "You've already voted for 5 products. Thank you!";
    } else {
        // Process selected product votes
        if (isset($_POST["vote"]) && is_array($_POST["vote"])) {
            foreach ($_POST["vote"] as $voted_product) {
                // Check if the user has already voted for this product
                if (!in_array($voted_product, $_SESSION['user_votes'])) {
                    // Update the user's voted products
                    $_SESSION['user_votes'][] = $voted_product;

                    // Update the product vote count
                    $product_votes[$voted_product]++;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Voting</title>
    <style>
        /* Add CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            font-size: 16px;
            margin: 10px 0;
        }
        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Vote for Products (Limit: 5 votes per user)</h2>
        <form method="POST" action="">
            <!-- Display products with inline CSS -->
            <label><input type="checkbox" name="vote[]" value="product1"> <span style="color: #007BFF;">Product 1</span> (Votes: <?php echo $product_votes['product1']; ?>)</label><br>
            <label><input type="checkbox" name="vote[]" value="product2"> <span style="color: #007BFF;">Product 2</span> (Votes: <?php echo $product_votes['product2']; ?>)</label><br>
            <label><input type="checkbox" name="vote[]" value="product3"> <span style="color: #007BFF;">Product 3</span> (Votes: <?php echo $product_votes['product3']; ?>)</label><br>
            <button type="submit" name="submitVote">Submit Vote</button>
        </form>
    </div>
</body>
</html>
