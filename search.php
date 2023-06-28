<?php
require 'includes/dbconn.php';

if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];

    // Escape the keyword to prevent SQL injection
    $escapedKeyword = $conn->real_escape_string($keyword);

    // Construct the SQL query
    $query = "SELECT * FROM comment WHERE content LIKE '%$escapedKeyword%' ORDER BY date_posted DESC";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query execution was successful
    if ($result) {
        // Fetch and display the search results
        while ($row = $result->fetch_assoc()) {
            echo "<p>Conversation ID: " . $row['comment_id'] . "</p>";
            echo "<p>Name: " . $row['user_id'] . "</p>";
            echo "<p>Message: " . $row['content'] . "</p>";
            // Display other relevant conversation details as needed
            echo "<hr>";
        }

        // Free the result set
        $result->free();
    } else {
        echo "Error executing the query: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
