<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload File PDF</title>
</head>
<body>
  <h2>Upload File PDF</h2>
  <form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="pdf_file" accept="application/pdf" required>
    <br><br>
    <button type="submit" name="submit">Upload</button>
  </form>
</body>
</html>
