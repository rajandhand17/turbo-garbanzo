<?php
// Include your header or database connection code here
include "header.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $add_text = htmlspecialchars($_POST['add_text']);
    $alt_text = htmlspecialchars($_POST['alt_text']);
    $image_name = htmlspecialchars($_POST['image_name']);

    // Handle the file upload
    if (isset($_FILES['add_icon']) && $_FILES['add_icon']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../images/"; // Directory to store the uploaded file
        $file_name = basename($_FILES['add_icon']['name']);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['add_icon']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Check file size (2MB max)
        if ($_FILES['add_icon']['size'] > 2 * 1024 * 1024) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }

        // Upload the file
        if (move_uploaded_file($_FILES['add_icon']['tmp_name'], $target_file)) {
            echo "The file " . htmlspecialchars($file_name) . " has been uploaded.";

            // Insert the data into the database
            try {
                $query = "INSERT INTO media (media_path, description, media_name, project_name) 
                          VALUES (:media_path, :description, :media_name, :project_name)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'media_path' => "images/$file_name",
                    'description' => $alt_text,
                    'media_name' => $image_name,
                    'project_name' => $add_text
                ]);

                echo "Data successfully uploaded!";
            } catch (Exception $e) {
                echo "Error inserting data: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!-- HTML Form for Uploading New Banner -->
<div class="page-container">
    <h2 class="main-heading">Add New Banner</h2>
    
    <!-- Banner Form -->
    <form action="add_banner.php" method="POST" enctype="multipart/form-data">
        
        <!-- Rich Text Editor (Optional) -->
        <div class="rich-text-editor">
            <select name="font">
                <option>Poppins</option>
                <option>Arial</option>
            </select>
            <select name="heading">
                <option>Heading 1</option>
                <option>Heading 2</option>
            </select>
            <button type="button">B</button>
            <button type="button">I</button>
            <button type="button">U</button>
            <button type="button">Align Left</button>
            <button type="button">Align Center</button>
            <button type="button">Align Right</button>
            <button type="button">Bullet List</button>
            <button type="button">Number List</button>
        </div>
        
        <!-- Add Text Section -->
        <div class="input-group">
            <label for="add-text">Add Text</label>
            <textarea name="add_text" id="add-text" placeholder="Enter text here"></textarea>
        </div>
        
        <!-- Add Icon Section -->
        <div class="input-group">
            <label for="add-icon">Add Icon</label>
            <input type="file" name="add_icon" id="add-icon" required>
        </div>
        
        <!-- Alt Text and Image Name -->
        <div class="input-group">
            <label for="alt-text">Alt Text</label>
            <input type="text" name="alt_text" id="alt-text" placeholder="Enter alternative text" required>
        </div>
        <div class="input-group">
            <label for="image-name">Image Name</label>
            <input type="text" name="image_name" id="image-name" placeholder="Enter image name" required>
        </div>
        
        <!-- Action Buttons -->
        <div class="actions">
            <button type="submit" class="btn upload">Upload</button>
        </div>
    </form>
</div>

<!-- Display the List of Uploaded Banners -->
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
                <img src="../<?php echo $row['media_path'] ?>" alt="Banner Image" class="image">
                <div class="details">
                    <h3 class="project-name">Project: <?php echo $row['project_name'] ?></h3>
                    <hr/>
                    <p>Alt Text: <?php echo $row['description'] ?></p>
                    <hr/>
                    <p>Image Name: <?php echo $row['media_name']; ?></p>
                    <hr/>
                </div>
                <div class="actions">
                    <a href="edit_banner.php?id=<?php echo $row['id']; ?>"><button class="btn edit-btn"><i class="fas fa-edit"></i>Edit</button></a>
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
</body>
</html>
