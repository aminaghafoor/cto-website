<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'amna');



// Handle search
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";

$stmt = $conn->prepare("SELECT observations.*, newuser.username FROM observations JOIN newuser ON observations.user_id = newuser.id WHERE comments LIKE ?");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | CTO</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header>
   <nav class="navbar">
       <h1 class="heading center">Admin Panel</h1>

     <div class="logout-container">
      <form action="Logout.php" method="post">
        <button class="exit" type="submit">Logout</button>
      </form>
</div>

    </nav>

  </header>
  
     <div class="center-logout">
  <form method="get" class="search-button">
       <input type="text" name="search" placeholder="Search comments" />
       <button type="submit">Search</button>
  </form>

</div>

<section class="viewpost-section">
 <?php while ($row = $result->fetch_assoc()): ?>
<div class="post-card" id="post-<?= $row['id'] ?>">
   <h3><?= htmlspecialchars($row['bird']) ?> spotted in <?= htmlspecialchars($row['location']) ?></h3>

   <p class="meta">
     <strong>By:</strong> <?= htmlspecialchars($row['username']) ?> |
     <?= $row['date'] ?> <?= $row['time'] ?>
   </p>

   <p>
     <strong>Activity:</strong> <?= htmlspecialchars($row['activity']) ?> |
     Duration: <?= $row['duration'] ?> mins
   </p>

   <p>
     <strong>Comments:</strong>
     <span class="comment"><?= htmlspecialchars($row['comments']) ?></span>
   </p>

   <?php if ($row['image']): ?>

     <div class="post-image">
       <img src="<?= htmlspecialchars($row['image']) ?>" alt="Bird Image">
     </div>
   <?php endif; ?>

   <br>

   <div class="post-actions">
   <button class="new-button" onclick="eP(<?= $row['id'] ?>)">Edit</button>
   <button class="new-button" onclick="dP(<?= $row['id'] ?>)">Delete</button>
 </div>

</div>

 <?php endwhile; ?>


 <script src="delete.js"></script>

</section>

</body>

<div class="bottom-footer">
    <p> © 2025 Centrala Trust for Ornithology. <br>
       All Rights Reserved.  <br>
       Developed By Amna</p>
    </div>


</html> 