<?php
require_once 'connection.php'; 

// Ensure DB connection is available
if (!function_exists('logActivity')) {
    /**
     * Log an activity to the database
     * 
     * @param string $action The action being performed (e.g., "Menambah berita", "Menghapus kategori")
     * @param array $details Optional array of details about the action
     * @return bool Success status of the log operation
     */
    function logActivity($action, $details = []) {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Get database connection
        require_once __DIR__ . '/connection.php';
        
        // Get user ID from session if available
        $user_id = isset($_SESSION['login']['id']) ? $_SESSION['login']['id'] : NULL;
        
        // Format action with details if provided
        if (!empty($details)) {
            $formatted_details = json_encode($details, JSON_UNESCAPED_UNICODE);
            $full_action = $action . ' - ' . $formatted_details;
        } else {
            $full_action = $action;
        }
        
        // Escape the action text
        global $connection;
        $full_action = mysqli_real_escape_string($connection, $full_action);
        
        // Build and execute the query
        $query = "INSERT INTO activity_logs (user_id, aksi) VALUES (";
        $query .= $user_id ? "'$user_id'" : "NULL";
        $query .= ", '$full_action')";
        
        return mysqli_query($connection, $query);
    }
}