<?php
// config.php

// Panggil Library Google yang sudah diinstall via Composer
require_once 'vendor/autoload.php';

// Mulai Session (Wajib, biar data login kesimpan sementara)
session_start();

$client = new Google_Client();
$client->setClientId('ini Client ID');
$client->setClientSecret('ini Client Secret');
$client->setRedirectUri('http://localhost:8000/auth_google.php'); // Sesuaikan dengan yang didaftarkan!

// --- ATUR IZIN AKSES (SCOPE) ---
// 1. Minta email & profil (Wajib buat login)
$client->addScope("email");
$client->addScope("profile");

$server = "localhost";
$user = "root";
$password = "";
$nama_database = "ticketing-website";

$conn = mysqli_connect($server, $user, $password, $nama_database);

if( !$conn ){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}


?>