<?php

/* header file that displays tabs in each page and called as needed in every page 
Author:- victor*/

require 'init.php'; // Start the session
require 'db.php'; // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameGrid</title>
    <link rel="stylesheet" href="style2.css"> <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
</head>
<style>

.search-bar {
    display: flex;
    flex-direction: row;
    align-items: center;
    max-width: 200px;
    width: 100%;
    margin: 0 1rem;
    border-radius: 8px;
    overflow: hidden;
}

.search-bar input {
    flex: 1;
    padding: 0.5rem 0.8rem;
    border: none;
    font-size: 0.70rem;
    outline: none;
    border-radius: 25px 0 0 25px;
    border-radius: 25px 0 0 25px; /* Rounded on left side only */
    margin: 0; /* Remove any margin */
}


.search-btn {
    padding: 0.5rem;
    background-color: #00ffc8;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0 25px 25px 0; /* Rounded on right side only */
    margin: 0; /* Remove any margin */
}

.search-btn:hover {
    background-color:#00e6b8;
}


/* Initial Hidden State */
.search-bar,
.nav-links {
    display: none;
    width: 100%;
    order: 3; /* Puts collapsed content below */
}



/* Active State using checkbox hack */
/* Active State using checkbox hack */
.navbar input[type="checkbox"]:checked ~ .search-bar {
    display: flex;
    flex-direction: row; /*  input and button stay side-by-side */
    width: 100%;
    animation: slideDown 0.3s ease-out;
    margin-bottom: 1rem;
}

.navbar input[type="checkbox"]:checked ~ .nav-links {
    display: flex;
    flex-direction: column; /* nav links still stack vertically */
    width: 100%;
    animation: slideDown 0.3s ease-out;
    margin-bottom: 2.5rem;
}


/* Mobile Styles */
@media (max-width: 768px) {
    .navbar > .search-bar,
    .navbar > .nav-links {
        display: none; /* Hide by default on mobile */
    }

     /* Fix nav links appearance on mobile */
     .nav-links {
        order: 3;
        width: 100%;
        margin: 0;
        padding: 0;
        gap: 0.5rem; /* Less gap between items on mobile */
    }

    .search-bar {
        order: 2;
        margin: 1rem 0;
        padding: 0 1rem;
        width: 90%; /* Slightly narrower than 100% to look better on mobile */
    }
     /* Style individual nav items on mobile */
     .nav-links li {
        width: 100%;
        text-align: center;
        padding: 0.5rem 0;
    }
}

/* Dropdown animation */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Navbar container */
.navbar {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background-color: #1e1e1e;
    position: relative;
    width: 100%;
    box-shadow: 0 0 15px rgba(0, 255, 200, 0.2),
                0 4px 30px rgba(0, 0, 0, 0.3);
}

/* Logo styling */
.logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #00ffc8;
    flex: 0 0 20%;
    margin-left: 1rem;
}

/* Hamburger menu button */
.menu-toggle {
    display: none; /* Hidden on desktop */
    background: none;
    border: none;
    font-size: 1.5rem;
    color: white;
    cursor: pointer;
    z-index: 100;
}

/* Hidden checkbox to toggle menu */
.navbar input[type="checkbox"] {
    display: none;
}

/* Label for checkbox (hamburger icon) */
.navbar label.menu-toggle {
    display: block; /* Visible on mobile */
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 101;
    font-size: 1.5rem;
    color: white;
    cursor: pointer;
}

/* Desktop Styles */
@media (min-width: 768px) {
    .navbar {
        flex-direction: row;
        align-items: center;
        flex-wrap: nowrap;
    }

    .logo {
        width: auto;
        margin-bottom: 0;
        margin-right: auto;
        text-align: left;
        flex: 0 0 20%;
    }

    .menu-toggle {
        display: none;
    }

    .nav-links {
        display: flex;
        width: auto;
        flex-direction: row;
        gap: 1.5rem;
    }

    .search-bar {
        display: flex;
        flex: 1;
        max-width: 400px;
        margin: 0 1rem;
    }
}
@media (min-width: 768px) {
    .navbar label.menu-toggle {
        display: none !important; /* Force hide on desktop */
    }
}



</style>

<script src="script.js" defer></script> 

<body>
<!-- Header Section -->
<header>
    <nav class="navbar">
        <!-- Hidden Checkbox (controls menu toggle) -->
        <input type="checkbox" id="menu-toggle-checkbox">

        <h1 class="logo">Game Grid</h1> <!-- Site Logo -->

        <!-- Label for the Checkbox (Hamburger Menu Icon) -->
        <label for="menu-toggle-checkbox" class="menu-toggle" aria-label="Toggle navigation menu">☰</label>

        <!-- Search Bar (sibling to checkbox, visible when toggled) -->
        <!-- Search Form -->
      
           <!-- Clean, connected Search Bar -->
           <form class="search-bar" method="GET" action="search.php">
            <input type="text" name="query" placeholder="Search games..."
                   value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>" required>
            <button type="submit" class="search-btn" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
</form>



        <!-- Navigation Links (sibling to checkbox, visible when toggled) -->
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <li><a href="profile.php">Profile</a></li> <!-- Always visible -->

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" class="btn" id="loginBtn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn" id="loginBtn">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>