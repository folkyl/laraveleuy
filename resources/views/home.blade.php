<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    {{-- Tampilkan pesan sukses/error --}}
    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h2>Halo, {{ session('admin_username') }}</h2>
    <a href="{{ route('logout') }}">Logout</a>

    @if (session('admin_role') === 'guru' && isset($guru))
    <h3>Data Guru</h3>
    <p><b>Nama:</b> {{ $guru->nama }}</p>
    <p><b>Mata Pelajaran:</b> {{ $guru->mapel }}</p>
    @endif

    @if (session('admin_role') === 'siswa' && isset($siswa))
    <h3>Data Siswa</h3>
    <p><b>Nama:</b> {{ $siswa->nama }}</p>
    <p><b>Tinggi Badan:</b> {{ $siswa->tb }}</p>
    <p><b>Berat Badan:</b> {{ $siswa->bb }}</p>
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