<html>
<head>
    <title>Upload Gambar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }
        
        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            font-size: 28px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }
        
        form {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            transition: transform 0.3s ease;
        }
        
        form:hover {
            transform: translateY(-5px);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        tr {
            margin-bottom: 15px;
            display: block;
        }
        
        td {
            padding: 10px 0;
        }
        
        td:first-child {
            font-weight: 600;
            color: #34495e;
            width: 120px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px dashed #3498db;
            border-radius: 6px;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        input[type="file"]:hover {
            background-color: #e8f4fc;
        }
        
        input[type="submit"] {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }
        
        input[type="submit"]:hover {
            background: linear-gradient(to right, #2980b9, #2471a3);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        a {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        a:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        
        @media (max-width: 600px) {
            form {
                padding: 20px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<h2>FORM UPLOAD FOTO</h2>

<form method="post" action="validasi_foto.php" enctype="multipart/form-data">
<table>
    <tr>
        <td>ID User</td>
        <td><input type="text" name="id_user" required></td>
    </tr>

    <tr>
        <td>Nama</td>
        <td><input type="text" name="nama" required></td>
    </tr>

    <tr>
        <td>Foto</td>
        <td><input type="file" name="foto" required></td>
    </tr>

    <tr>
        <td></td>
        <td><input type="submit" name="kirim" value="Upload"></td>
    </tr>
</table>
</form>

<br>
<a href="tampil_foto.php">Lihat Data</a>


</body>
</html>