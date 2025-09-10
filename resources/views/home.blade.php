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
    @endif

    {{-- Profil Siswa --}}
    @if (session('admin_role') === 'siswa' && $profilSiswa)
        <h4>Halo! Siswa {{ $profilSiswa->nama }}</h4>
        <h4>Tinggi Badan : {{ $profilSiswa->tb }}</h4>
        <h4>Berat Badan : {{ $profilSiswa->bb }}</h4>
    @endif

    {{-- Daftar Siswa & Guru hanya untuk admin --}}
    @if (session('admin_role') === 'admin')
        <h2>Daftar Siswa</h2>
        <a href="{{ route('siswa.create') }}">
            <button>+ Tambah Siswa</button>
        </a>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listSiswa as $siswa)
                    <tr>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->tb }}</td>
                        <td>{{ $siswa->bb }}</td>
                        <td>
                            <a href="{{ route('siswa.edit', $siswa->id) }}">Edit</a> |
                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Daftar Guru</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Mata Pelajaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listGuru as $guru)
                    <tr>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->mapel }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


</body>

</html>