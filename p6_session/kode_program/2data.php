<HTML>
    <head>
        <style>
            body {
            background-color: #f0f4c3;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
            }
            h1 {
            color: #33691e;
            }
            form {
            background-color: #ffffff;
            border: 2px solid #c5e1a5;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            }
            input[type="text"] {
            padding: 6px;
            margin: 5px 0;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
            }
            input[type="submit"] {
            background-color: #8bc34a;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            }
            input[type="submit"]:hover {
            background-color: #689f38;
            }
        </style>

    </head>
<BODY>
    <H1> Selamat Datang di Situs Kami </H1>
    Silakan isi identitas Anda <BR>
    <FORM METHOD="POST" ACTION="2proses.php">
    <PRE>
        Nama : <INPUT TYPE="text" NAME="nama">
        Umur : <INPUT TYPE="text" NAME="umur"> tahun
        Email : <INPUT TYPE="text" NAME="email">
        <INPUT TYPE="submit" VALUE="Submit">
    </PRE>
    </FORM>
</BODY>
</HTML>