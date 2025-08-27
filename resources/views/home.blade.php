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
            @foreach($listSiswa as $i => $s)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->tb }}</td>
                <td>{{ $s->bb }}</td>
                <td>
                    @if (session('admin_role') === 'admin')
                    <a href="{{ route('siswa.edit', $s->id) }}">
                        <button type="button">Edit</button>
                    </a>
                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data {{ $s->nama }}?')">
                            Hapus
                        </button>
                    </form>

                    @else
                    <span>(Tidak ada aksi)</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>