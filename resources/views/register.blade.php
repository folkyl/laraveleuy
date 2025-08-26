<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script>
        function showChoice(role) {
            document.getElementById('guruFields').style.display = (role === 'guru') ? 'block' : 'none';
            document.getElementById('siswaFields').style.display = (role === 'siswa') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h2>Register</h2>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <label><input type="radio" name="role" value="admin" oninput="showChoice(this.value)" required> Admin</label>
        <label><input type="radio" name="role" value="guru" oninput="showChoice(this.value)"> Guru</label>
        <label><input type="radio" name="role" value="siswa" oninput="showChoice(this.value)"> Siswa</label>

        {{-- Tambahan field untuk guru --}}
        <div id="guruFields" style="display:none; margin-top:10px;">
            <input type="text" name="nama" placeholder="Nama Guru"><br>
            <input type="text" name="mapel" placeholder="Mata Pelajaran"><br>
        </div>

        {{-- Tambahan field untuk siswa --}}
        <div id="siswaFields" style="display:none; margin-top:10px;">
            <input type="text" name="nama" placeholder="Nama Siswa"><br>
            <input type="number" name="tb" placeholder="Tinggi Badan"><br>
            <input type="number" name="bb" placeholder="Berat Badan"><br>
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>
