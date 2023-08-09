<?php

function koneksi()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "sig_kost";

    $conn = new mysqli($host, $user, $pass, $db);

    return $conn;
}

// Untuk menampikan 1 baris pada table
function query($s)
{
    $conn = koneksi();

    $data = $conn->query($s);

    return $data->fetch_assoc();
}

// Untuk menampilkan banyak data
function queryAll($s)
{
    $conn = koneksi();

    $data = $conn->query($s);

    $rows = [];
    while ($row = $data->fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
}

    // fungsi tampil marker
