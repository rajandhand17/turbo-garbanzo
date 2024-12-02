<?php
// Include your database connection
include "header.php";

// Check if an ID is passed via POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch the image path before deleting the record to remove the file from the server
    try {
        // Fetch the media record to get the file path
        $query = "SELECT media_path FROM media WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // File path
            $file_path = "../" . $row['media_path'];

            // Delete the record from the database
            $delete_query = "DELETE FROM media WHERE id = :id";
            $delete_stmt = $pdo->prepare($delete_query);
            $delete_stmt->execute(['id' => $id]);

            // Check if the file exists and delete it
            if (file_exists($file_path)) {
                unlink($file_path); // Delete the file
            }

            echo "Banner deleted successfully.";
            header("Location: media.php"); // Redirect to media list page
            exit;
        } else {
            echo "Record not found.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No banner ID provided.";
}
?>
