<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <h2>Halo, {{ session('admin_username') }}</h2>
    <h3>Role anda : {{ ucfirst(session('admin_role'))  }}</h3>
    <a href="{{ route('logout') }}">Logout</a>

        {{-- Profil Guru --}}
        @if (session('admin_role') === 'guru' && $profilGuru)
            <h4>Halo! Guru {{ $profilGuru->nama }}</h4>
            <h4>Mata Pelajaran : {{ $profilGuru->mapel }}</h4>

            {{-- info walas --}}
                        @if ($kelasInfo && $walasInfo)
                <h4>Wali Kelas : {{ $kelasInfo->jenjang }} {{ $kelasInfo->namakelas }}</h4>
                <h4>Tahun Ajaran : {{ $kelasInfo->tahunajaran }}</h4>
                <h4>Jumlah Siswa : {{ $walasInfo->count() }} siswa</h4>
            @else
                <h4>(Anda bukan wali kelas)</h4>
            @endif
        @endif

        {{-- Profil Siswa --}}
        @if (session('admin_role') === 'siswa' && $profilSiswa)
            <h4>Halo! Siswa {{ $profilSiswa->nama }}</h4>
            <h4>Tinggi Badan : {{ $profilSiswa->tb }}</h4>
            <h4>Berat Badan : {{ $profilSiswa->bb }}</h4>
            @if ($kelasInfo && $walasInfo)
                <h4>Kelas : {{ $kelasInfo->walas->jenjang }} {{ $kelasInfo->walas->namakelas }}</h4>
                <h4>Wali Kelas : {{ $walasInfo->nama }}</h4>
                <h4>Tahun Ajaran : {{ $kelasInfo->walas->tahunajaran }}</h4>
            @endif
        @endif


    <h2>Daftar Siswa</h2>

    {{-- Tombol tambah siswa hanya untuk admin --}}
    @if (session('admin_role') === 'admin')
    <a href="{{ route('siswa.create') }}">
        <button>+ Tambah Siswa</button>
    </a>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tinggi Badan</th>
                <th>Berat Badan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listSiswa as $siswa)
            <tr>
                <td>{{ $siswa->idsiswa }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->tb }}</td>
                <td>{{ $siswa->bb }}</td>
                <td>{{ $siswa->idadmin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>