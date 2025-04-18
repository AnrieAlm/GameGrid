<?php
require 'init.php'; // if you're using session or other initial config
require 'db.php';   // database connection

// Check if the request was triggered by the "Search" button
if (!isset($_GET['search_button'])) {
    echo "<p>Invalid request. Please use the search form.</p>";
    exit;
}

// Get the search query
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
        <a href="index.php">← Back to Home</a>
    </header>

    <main>
        <?php
        if ($query) {
            // Validate the search query
            if (strlen($query) < 3) {
                echo "<p>Please enter a search term with at least 3 characters.</p>";
            } else {
                // Prepare and execute a search query
                $stmt = $pdo->prepare("SELECT * FROM games WHERE LOWER(title) LIKE :search");
                $stmt->execute(['search' => '%' . strtolower($query) . '%']);
                $results = $stmt->fetchAll();

                if ($results) {
                    echo "<ul class='search-results'>";
                    foreach ($results as $game) {
                        echo "<li>";
                        // Highlight the search term in the title
                        $highlightedTitle = preg_replace(
                            '/(' . preg_quote($query, '/') . ')/i',
                            '<mark class="highlight">$1</mark>',
                            htmlspecialchars($game['title'])
                        );
                        echo "<strong>" . $highlightedTitle . "</strong><br>";
                        if (isset($game['description'])) {
                            echo "<small>" . htmlspecialchars($game['description']) . "</small>";
                        }
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No results found for your search.</p>";
                }
            }
        } else {
            echo "<p>No search query provided.</p>";
        }
        ?>
    </main>
</body>
</html>