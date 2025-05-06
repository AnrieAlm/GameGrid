<?php

/* about us file containing our details */

// Include the database connection file
require_once 'db.php';

// Fetch team members from the "about_us" table
try {
    $stmt = $pdo->query("SELECT name, role, image FROM about_us");
    $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error and display a user-friendly message
    error_log("Database error: " . $e->getMessage());
    $teamMembers = []; // Fallback to an empty array
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style2.css">
</head>
<style>
    body {
        font-family: sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }
    main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    h1, h2 {
        color: white;
    }
    .team-member {
        display: inline-block;
        margin: 50px;
        text-align: center;
    }
    .team-member img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }
    .contact-info {
        margin-top: 30px;
    }
</style>

<body>
    <!-- Header Section: Logo, GameGrid Search, Menu Button -->
    <?php include 'header.php'; ?>

    <main>
        <h1>About Us</h1>

        <section>
            <h2>Our Team</h2>
            <?php
            if (!empty($teamMembers)) {
                foreach ($teamMembers as $member) {
                    echo '<span class="team-member">';
                    echo '<img src="' . htmlspecialchars($member['image']) . '" alt="' . htmlspecialchars($member['name']) . '">';
                    echo '<h3>' . htmlspecialchars($member['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($member['role']) . '</p>';
                    echo '</span>';
                }
            } else {
                echo '<p>No team members available at the moment.</p>';
            }
            ?>
        </section>

        <section>
            <h2>Our Story</h2>
            <p>We started in 2025 with a simple vision: to give users one of the best games reviews.
                Ever since, we have been working tirelessly to achieve our aim.</p>
            <p>In the last months, we've grown and evolved, achieving milestones like posting professional reviews on
                any newly released game almost immediately.</p>
        </section>

        <section>
            <h2>Our Mission</h2>
            <p>Our mission is to increase gamers' happiness and build awareness for wonderful games people might not know about.
                We strive to increase gamers in the world.</p>
        </section>

        <section>
            <h2>Our Values</h2>
            <ul>
                <li>Best Game Reviews</li>
                <li>User Focused</li>
                <li>Teamwork</li>
            </ul>
        </section>

        <section class="contact-info">
            <h2>Contact Us</h2>
            <p>Email: <a href="mailto:info@gamegrid.com">info@gamegrid.com</a></p>
            <p>Address: Griffith College, Dublin</p>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>