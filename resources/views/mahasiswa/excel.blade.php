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
</table>