<?php 
session_start();
$conn = new mysqli("localhost","root","","db-sepatubaru");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 
 ?>