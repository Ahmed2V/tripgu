<?php
// Database connection parameters
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "mine";

try {   
    // Create a new PDO connection
    $conn = new PDO("mysql:host=localhost;dbname=mine", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check request method
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        // Get user ID from query parameters
        $username = isset($_GET['username']) ? $_GET['username'] : null;

        // Validate user ID
        if (!$username || !is_numeric($username)) {
            echo json_encode(array("error" => "Invalid username"));
            exit();
        }

        // Retrieve favorite items for the user
        $stmt = $conn->prepare("SELECT * FROM favorite WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);
        $stmt->execute();
        $favorite = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($favorite);
    } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Add a new favorite item
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate input
        if (!isset($data['username']) || !isset($data['item_id']) ) {
            echo json_encode(array("error" => "Missing required parameters"));
            exit();
        }

        // Insert favorite item into database
        $stmt = $conn->prepare("INSERT INTO favorite_items (username, item_id) VALUES (:username, :item_id)");
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
       
        $stmt->execute();

        echo json_encode(array("message" => "Favorite item added successfully"));
    } elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
        // Remove a favorite item
        parse_str(file_get_contents("php://input"), $data);

        // Validate input
        if (!isset($data['username']) || !isset($data['item_id'])) {
            echo json_encode(array("error" => "Missing required parameters"));
            exit();
        }

        // Delete favorite item from database
        $stmt = $conn->prepare("DELETE FROM favorite WHERE username= :username AND item_id = :item_id");
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_INT);
        $stmt->bindParam(':item_id', $data['item_id'], PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(array("message" => "Favorite item removed successfully"));
    } else {
        // Unsupported request method
        echo json_encode(array("error" => "Unsupported request method"));
    }
} catch (PDOException $e) {
    // Database connection error
    echo json_encode(array("error" => "Database connection failed: " . $e->getMessage()));
}
?>
