<?php
include "db.php";

if (isset($_POST['submit'])) {
    $file = $_FILES['pdf_file'];
    $username = "dini"; // Ganti sesuai nama Anda

    // Validasi 1: Pastikan file diupload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Gagal mengunggah file. Error code: " . $file['error']);
    }

    // Validasi 2: Cek tipe file
    $fileType = mime_content_type($file['tmp_name']);
    if ($fileType !== 'application/pdf') {
        die("❌ Hanya file PDF yang diperbolehkan.");
    }

    // Validasi 3: Batas ukuran (10MB)
    $maxSize = 10 * 1024 * 1024; // 10 MB
    if ($file['size'] > $maxSize) {
        die("❌ Ukuran file maksimal 10 MB.");
    }

    // Menyiapkan nama file unik
    $timestamp = time();
    $originalName = basename($file['name']);
    $newFileName = $username . "_" . $timestamp . "_" . $originalName;

    // Direktori penyimpanan
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetPath = $uploadDir . $newFileName;

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO tb_upload (path, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $targetPath, $originalName);
        $stmt->execute();
        $stmt->close();

        echo "✅ File berhasil diunggah!<br>";
        echo "📄 Path: " . $targetPath;
    } else {
        echo "❌ Gagal menyimpan file.";
    }

    $conn->close();
}
?>
