<?php
// Database connection setup
require 'init.php'; // Start the session
require 'db.php'; // Database connection

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the user submitted a search query
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if (!empty($searchQuery)) {
    // Prepare a SQL query to search for games by title
    $sql = "
        SELECT g.id, g.title, g.description, g.rating, GROUP_CONCAT(p.name SEPARATOR ', ') AS platforms
        FROM games g
        JOIN game_platforms gp ON g.id = gp.game_id
        JOIN platforms p ON gp.platform_id = p.id
        WHERE g.title LIKE :query
        GROUP BY g.id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => '%' . $searchQuery . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .search-form { margin-bottom: 20px; }
        .game { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; }
        .no-results { color: red; }
    </style>
</head>
<body>
    <h1>Search for Games</h1>

    <!-- Search Form -->
    <form class="search-form" method="GET" action="search.php" onsubmit="saveSearchQuery()">
        <input type="text" id="searchInput" name="query" placeholder="Enter game title..." value="<?= htmlspecialchars($searchQuery) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($searchQuery)): ?>
        <h2>Search Results for: "<?= htmlspecialchars($searchQuery) ?>"</h2>

        <?php if (!empty($results)): ?>
            <?php foreach ($results as $game): ?>
                <div class="game">
                    <h3><?= htmlspecialchars($game['title']) ?></h3>
                    <p><?= htmlspecialchars($game['description']) ?></p>
                    <p><strong>Rating:</strong> <?= htmlspecialchars($game['rating']) ?>/5</p>
                    <p><strong>Platforms:</strong> <?= htmlspecialchars($game['platforms']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-results">No games found matching your search.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
<script>
        // Restore search input from localStorage
        window.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            const saved = localStorage.getItem('lastSearch');
            if (input && saved) input.value = saved;
        });

        function saveSearchQuery() {
            const input = document.getElementById('searchInput');
            localStorage.setItem('lastSearch', input.value);
        }
    </script>
</body>
</html>