<?php 
include("header.php");
?>

<h2>Image List</h2>
<div class="image-grid">
    <?php 
    $query = "SELECT * FROM media";
    $stmt = $pdo->query($query);

    // Check if there are results
    if ($stmt->rowCount() > 0) {
        // Loop through the results
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <!-- Card 1 -->
            <div class="image-card">
                <img src="../<?php echo $row['media_path'] ?>" alt="Modern Apartment" class="image">
                <div class="details">
                    <h3 class="Project-name">Project: <?php echo $row['project_name'] ?></h3>
                    <hr/>
                    <p>Alt Keyword: <?php echo $row['description'] ?></p>
                    <hr/>
                    <p>Image Name: <?php echo $row['media_name']; ?></p>
                    <hr/>
                </div>
                <div class="actions">
                    <a href="edit_banner.php?id=<?php echo $row['id']; ?>"><button class="btn edit-btn"><i class="fas fa-edit"></i> Edit</button></a>
                    <!-- Delete button with confirmation -->
                    <form action="delete_banner.php" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No records found in the media table.";
    }
    ?>
</div>
</div>
</div>
</body>
</html>
