<?php // connecting to mySQL server in php and the other php files as well
$host = 'localhost'; // Database host
$dbname = 'gamegrid'; // Database name
$username = 'root'; // Database username
$password = 'root'; // Fixed typo


try{$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name);}

    catch(mysqli_sql_exception){
        echo "Could not connect! <br>"; 
    }


if($conn){
    echo "You are connected! <br>"; 
} else {
    echo "Could not connect: " . mysqli_connect_error();
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}



// Include database connection
require_once 'db.php';



// Get POST data
$userId = $_SESSION['user_id'];
$gameId = $_POST['game_id'];

// Validate input
if (!is_numeric($gameId)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid game ID']);
    exit;
}

// Check if the game exists
$stmt = $pdo->prepare("SELECT id FROM games WHERE id = :game_id");
$stmt->execute(['game_id' => $gameId]);
if (!$stmt->fetch()) {
    http_response_code(404); // Not Found
    echo json_encode(['success' => false, 'message' => 'Game not found']);
    exit;
}

// Check if the bookmark already exists
$stmt = $pdo->prepare("SELECT * FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
$stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
$bookmarkExists = $stmt->fetch();

if ($bookmarkExists) {
    // Remove the bookmark
    $stmt = $pdo->prepare("DELETE FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
    $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    echo json_encode(['success' => true, 'action' => 'removed']);
} else {
    // Add the bookmark
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, game_id) VALUES (:user_id, :game_id)");
    $stmt->execute(['user_id' => $userId, 'game_id' => $gameId]);
    echo json_encode(['success' => true, 'action' => 'added']);
}




?>