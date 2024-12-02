<?php
include "header.php";

// Initialize the $result variable
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete functionality
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];

        // Fetch the current media details to remove the file if necessary
        $query = "SELECT media_path FROM media WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $media = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($media) {
            // Remove the file from the directory
            $file_path = "../" . $media['media_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Delete the record from the database
            $query = "DELETE FROM media WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['id' => $id]);

            echo "<script>alert('Record deleted successfully!'); window.location.href = 'media_list.php';</script>";
            exit;
        } else {
            echo "Media record not found.";
        }
    }

    // Handle the file upload
    if (isset($_FILES['image_file'])) {
        $target_dir = "../images/";
        $file_name = basename($_FILES['image_file']['name']);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image type
        $check = getimagesize($_FILES['image_file']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (limit to 2MB)
        if ($_FILES['image_file']['size'] > 2 * 1024 * 1024) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $id = (int)$_POST['id'];
                $alt_text = htmlspecialchars($_POST['alt_text']);
                $image_name = htmlspecialchars($_POST['image_name']);

                $query = "UPDATE media SET media_path = :media_path, description = :alt_text, project_name = :image_name WHERE id = :id";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'media_path' => "images/$file_name",
                    'alt_text' => $alt_text,
                    'image_name' => $image_name,
                    'id' => $id
                ]);

                echo "Database updated successfully.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// Get the ID from the URL and validate it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Use a prepared statement to safely execute the query
    $query = "SELECT * FROM media WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        echo "Record not found.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Image</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>

<div class="image-details-card">
    <div class="image-preview">
        <img class="image-details" src="../<?php echo htmlspecialchars($result['media_path']); ?>" alt="Uploaded Project Preview">
    </div>
    <div class="details">
        <h2>Update Image In Specific Project</h2>
        <hr/>
        <p><strong>File Name:</strong> <?php echo htmlspecialchars($result['media_name']); ?></p>
        <hr>
        <div class="form">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id']); ?>">
                <label for="alt-text">Alternative Text</label>
                <input type="text" id="alt-text" name="alt_text" value="<?php echo htmlspecialchars($result['description']); ?>" placeholder="Enter alternative text">
                <label for="image-name">Image Name</label>
                <input type="text" id="image-name" name="image_name" value="<?php echo htmlspecialchars($result['project_name']); ?>" placeholder="Enter image name">
                <label for="file-name">Choose File</label>
                <input type="file" id="file-name" name="image_file">

                <div class="actions">
                    <button class="btns delete" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                    <button type="submit" class="btn upload">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
