<html>
<head>
<title>Form upload file</title>
</head>
<body>
    <h1>Upload file</h1>
    <p>Klik Browser Uuntuk memillih file</p>
    <form enctype="multipart/form-data" method="post" action="6do_upload.php">
    <!-- Batas maksimum  file (dalam byte) -->
     <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <label>pilih file:</label>
    <input type="file" name="file1" size="30" required>
    <br><br>
    <input type="submit" value="upload">
    </form>
</body>
</html>