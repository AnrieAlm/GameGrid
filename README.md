---

#  GameGrid

A dynamic and responsive game review website built using HTML, CSS, JavaScript, PHP, and MySQL.

> Developed as a group project for the SEWA module at Griffith College Dublin.

---

##  Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Database Structure](#database-structure)
- [CRUD Operations](#crud-operations)
- [Extra Features](#extra-features)
- [Responsive Design](#responsive-design)
- [Team Contributions](#team-contributions)
- [File Structure](#file-structure)
- [Future Improvements](#future-improvements)
- [References](#references)

---

##  Overview

GameGrid is a fully functional game review platform where users can:

- Explore trending games
- Create an account & log in
- Bookmark their favorite titles
- View detailed reviews
- Personalize their profile
- Switch between dark/light modes

---

##  Features

-  User authentication (Login, Register, Logout)
-  Game CRUD (Create, Read, Update, Delete) using PHP/MySQL
-  Responsive design with dark mode toggle
-  Search by game title
-  Bookmark favorite games (stored locally)
-  Profile page and preferences
-  Grid/List toggle for viewing reviews
-  Hero slider for featured games

---

##  Tech Stack

| Layer        | Technology                    |
|--------------|-------------------------------|
| Frontend     | HTML, CSS, JavaScript         |
| Backend      | PHP                           |
| Database     | MySQL                         |
| Hosting      | Online server (URL TBD)       |
| Versioning   | Git (local)                   |

---

##  Getting Started

### 1. Clone the Repo

bash
git clone https://github.com/your-username/gamegrid.git
cd gamegrid


### 2. Set Up the Database

Create a MySQL database a schema (export from phpMyAdmin or use provided .sql file):

sql
CREATE DATABASE game_grid;
USE game_grid;


Add user:

sql
CREATE USER 'game_grid1'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON game_grid.* TO 'game_grid1'@'localhost';


Update /php/db.php with your database credentials.

---

## Database Structure

Database: game_grid

### Tables:

#### users

| Field       | Type         |
| ----------- | ------------ |
| id          | INT (PK)     |
| username    | VARCHAR(255) |
| email       | VARCHAR(255) |
| password    | VARCHAR(255) |
| preferences | TEXT         |

#### games

| Field      | Type         |
| ---------- | ------------ |
| id         | INT (PK)     |
| title      | VARCHAR(255) |
| rating     | VARCHAR(10)  |
| image\_url | VARCHAR(255) |

---

##  CRUD Operations (PHP + MySQL)

### Create

php
$stmt = $pdo->prepare("INSERT INTO games (title, rating, image_url) VALUES (?, ?, ?)");
$stmt->execute([$title $rating, $image_url]);


### Read

php
$stmt = $pdo->query("SELECT * FROM games");
while ($row = $stmt->fetch()) {
    echo htmlspecialchars($row['title']);
}


### Update

php
$stmt = $pdo->prepare("UPDATE games SET title = ?, rating = ? WHERE id = ?");
$stmt->execute([$new_title, $new_rating, $game_id]);


### Delete

php
$stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
$stmt->execute([$game_id]);


---

##  Extra Features

*  Hero slider for dynamic homepage banners
*  Dark mode (toggle switch stored in localStorage)
*  Game review filtering and search
*  Bookmark games via localStorage
*  Dynamic UI interactions via JavaScript
*  PHP includes for header/footer reusability

---

##  Responsive Design

*  Works on all screen sizes (media queries)
*  Dark mode with WCAG AA contrast compliance
*  Intuitive layout using CSS Grid and Flexbox
*  Focus/hover states for accessibility
*  Client-side form validation with custom error indicators

---

##  Team Contributions
CSS and HTML were equally divded among the 3 of us.
| Name           | Student ID | Contributions                                                                |
| -------------- | ---------- | ---------------------------------------------------------------------------- |
| Neil Joseph    | 3168101    | Deployment, login system, CRUD in PHP, JS scripting                          |
| Victor Adisa   | 3166231    | User registration, validation, platform filtering, comments & review styling |
| Anriel Almeida | 3168178    | Styling (CSS), PHP templating, SQL setup, profile UI, search bar             |

---

##  File

/gamegrid
│
├── /css
│   └── style2.css
├── /images
│   └── hero.jpg, game1.jpg, game2.jpg
├── /icons
│
├── /php
│   ├── db.php
│   ├── header.php
│   ├── footer.php
│   ├── slides.php
│   ├── index.php
│   ├── aboutus.php
│   ├── account_settings.php
│   ├── auth.php
│   ├── comments.php
│   ├── dataBase.php
│   ├── formhandler.php
│   ├── inner-review.php
│   ├── search.php
│   ├── login.php
│   ├── register.php
│   ├── slides.php
│   ├── init.php
│   ├── edit_profile.php
│   ├── logout.php
│   ├── change_password.php
│   ├── profile.php
│   ├── test_db.php
│   ├── update_password.php
│
├── login.js
├── script.js
├── review.js
├── README.md
├── coversheet.pdf
├── style2.css



---

##  Future Improvements

- Filter reviews by platform (PS5, PC, etc.)
-  Editable profile with user data
-  Admin panel for managing reviews
-  Email-based password reset
-  Convert bookmarks to user-specific database table
-  Improve mobile UI further

---

##  References

W3Schools (2024) SQL Tutorial. Available at: https://www.w3schools.com/sql/ (Accessed: 6 May 2025). 

Learned how to use the SELECT statement with ORDER BY and LIMIT, applied in PHP to fetch top trending games. 

Understood SQL syntax and database querying. 

Stack Overflow (2024) Stack Overflow – Where Developers Learn, Share, & Build Careers. Available at: https://stackoverflow.com/ (Accessed: 6 May 2025). 

Found a solution for a PDOException error handling block, used to wrap PHP queries in a try...catch block. 

Utilized community-driven solutions for specific coding problems. 

FreeCodeCamp (2024) Learn to Code — For Free. Available at: https://www.freecodecamp.org/ (Accessed: 6 May 2025). 

Learned about responsive design techniques using media queries for mobile-friendly interfaces. 

Understood how to use semantic HTML5 tags to improve accessibility and structure. 

Krossing, D. (2023) 25 | How to Create Sessions in PHP for Beginners | 2023 | Learn PHP Full Course For Beginners. Available at: https://www.youtube.com/watch?v=JAgd_L3GhI0 (Accessed: 17 April 2025). 

Learned how to initiate and manage $_SESSION in PHP to persist user login state across pages. 

Understood the importance of session_start() placement at the beginning of PHP files. 

Krossing, D. (2023) 22 | INSERT INTO Database Using PHP From Your Website! | 2023 | Learn PHP Full Course for Beginners. Available at: https://www.youtube.com/watch?v=IagGGcC95Ig (Accessed: 17 April 2025). 

Learned how to safely insert form data into a database using prepared statements with PDO. 

Understood the correct structure of using $_POST to retrieve form values and bind them into a query. 

Krossing, D. (2023) Learn Object Oriented PHP for Beginners | With Examples to Help You Understand! | OOP PHP Tutorial. Available at: https://www.youtube.com/watch?v=yrFr5PMdk2A&t=4s (Accessed: 17 April 2025). 

Learned how to define classes and methods in PHP for efficient code organization. 

Understood the concept of encapsulation and how to use public/private properties in PHP objects. 

Stack Overflow Contributors (n.d.) PHP Notes for Professionals. Available at: file:///C:/Users/Anriel/Downloads/PHPNotesForProfessionals.pdf (Accessed: 17 April 2025). 

Learned various PHP string and array manipulation functions for displaying and filtering user content. 

Understood security practices such as escaping output with htmlspecialchars() to prevent XSS. 

FreeCodeCamp.org (n.d.) PHP Programming Language Tutorial - Full Course. Available at: https://www.youtube.com/watch?v=OK_JCtrrv-c (Accessed: 17 April 2025). 

Learned how to connect to a MySQL database using PDO and handle exceptions. 

Understood structuring PHP files with includes (e.g., require 'db.php') for modular and reusable code. ---