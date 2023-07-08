<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    {{-- <form action="{{ route('store') }}" method="POST"> --}}
    @csrf

    <div>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required>
    </div>

    <div>
        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" id="alamat" required>
    </div>
    <div>
        <label for="telepon">telepon:</label>
        <input type="text" name="telepon" id="telepon" required>
    </div>

    <div>
        <label for="sms_wa">sms_wa:</label>
        <input type="text" name="sms_wa" id="sms_wa" required>
    </div>

    <!-- Tambahkan input untuk kolom-kolom lain yang diperlukan -->

    <button type="submit">Simpan</button>
</form>

</body>
</html>