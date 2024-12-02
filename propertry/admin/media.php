<?php 
include("header.php");

// Fetch all images from the database
$query = "SELECT * FROM media";
$stmt = $pdo->query($query);

// Check if there are any records
$images = [];
if ($stmt->rowCount() > 0) {
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

        <h2>Image List</h2>
        <div class="image-cards">
            <?php if (count($images) > 0): ?>
                <?php $counter = 0; ?>
                <?php foreach ($images as $image): ?>
                    <!-- Start a new row after 3 images -->
                    <?php if ($counter % 3 == 0 && $counter != 0): ?>
                        </div><div class="image-cards">
                    <?php endif; ?>
                    <img src="../<?php echo htmlspecialchars($image['media_path']); ?>" alt="<?php echo htmlspecialchars($image['description']); ?>" class="image">
                    <?php $counter++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No images found in the database.</p>
            <?php endif; ?>
        </div>
    </div>
  </div>
</body>
</html>
