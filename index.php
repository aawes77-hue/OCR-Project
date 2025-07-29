<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $imagePath = 'uploads/' . basename($_FILES['image']['name']);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        // Run OCR using Tesseract
        $output = shell_exec("tesseract $imagePath stdout 2>&1");

        if ($output) {
            echo "<table border='1' cellpadding='8' cellspacing='0'>";
            echo "<tr><th>Line Number</th><th>Extracted Text</th></tr>";

            $lines = preg_split('/\r\n|\r|\n/', $output);
            foreach ($lines as $index => $line) {
                $line = trim($line);
                if (!empty($line)) {
                    echo "<tr><td>" . ($index + 1) . "</td><td>" . htmlspecialchars($line) . "</td></tr>";
                }
            }
            echo "</table>";
        } else {
            echo "<p>No text extracted. Please check the image.</p>";
        }
    } else {
        echo "<p>File upload failed.</p>";
    }
} else {
    echo "<p>Invalid request. Please upload an image.</p>";
}
?>
