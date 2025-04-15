
<?php
// Include the database connection file
require 'db.php'; // Database connection

// Check if the request method is GET (search query)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = $_GET['query']; // Get search query from URL parameter

    // Prepare SQL query to search games by title
    $stmt = $pdo->prepare("SELECT * FROM games WHERE title LIKE :query");
    $stmt->execute(['query' => "%$query%"]); // Execute query with search term
    $results = $stmt->fetchAll(); // Fetch all matching results

    // Loop through and display each result
    foreach ($results as $result) {
        echo "<li>{$result['title']} - {$result['description']}</li>";
    }
}
?>
<!-- HTML form for searching games -->
<form method="GET">
    <input type="text" name="query" placeholder="Search games..."> <!-- Input field for search query -->
    <button type="submit">Search</button> <!-- Submit button -->
</form>