<table border="1">
    <tr>
        <th>ID</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
    </tr>

    @foreach($mahasiswa as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->nim }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->detail_jurusan->nama_jurusan ?? '-'}}</td>
    </tr>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Jurusan</th>
            <th>Akreditasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jurusans as $index => $jurusan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $jurusan->nama_jurusan }}</td>
            <td>{{ $jurusan->akreditasi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>