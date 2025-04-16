
<?php
require_once 'db.php'; // Include the database connection file

$sqlSlides = "SELECT * FROM games LIMIT 3";
$resultSlides = $conn->query($sqlSlides);
//const slides = JSON.stringify(results);
$slides = [];
while ($row = $resultSlides->fetch_assoc()) {
    $slides[] = [
        'title' => $row['title'],
        'platform' => $row['platform'],
        'rating' => $row['rating'],
        'description' => $row['description'],
        'link' => '#',
        'image' => $row['image_url']
    ];
}

header('Content-Type: application/json'); // Set the response content type to JSON
echo json_encode($slides); // Output the slides array as JSON
?>