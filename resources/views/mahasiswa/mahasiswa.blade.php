<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: 250px; height: 100vh;
            background: linear-gradient(180deg, #1a1a2e, #16213e, #0f3460);
            position: fixed; top: 0; left: 0; padding: 20px 0; z-index: 100;
        }
        .sidebar-brand {
            color: #fff; font-size: 18px; font-weight: 700;
            padding: 15px 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand i { color: #e94560; font-size: 22px; }
        .sidebar-menu { list-style: none; padding: 20px 0; margin: 0; }
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 25px; color: rgba(255,255,255,0.7);
            text-decoration: none; transition: all 0.3s; font-size: 14px;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: rgba(233,69,96,0.2); color: #fff;
            border-left: 3px solid #e94560;
        }
        .sidebar-menu li a i { width: 20px; }
        .main-content { margin-left: 250px; }
        .topbar {
            background: #fff; padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .topbar h5 { margin: 0; color: #1a1a2e; font-weight: 600; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #e94560, #c62a47);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: #fff; font-weight: 700;
        }
        .btn-logout {
            background: linear-gradient(135deg, #e94560, #c62a47);
            border: none; color: #fff; padding: 7px 18px;
            border-radius: 8px; font-size: 13px;
        }
        .btn-logout:hover { color: #fff; }
        .content-area { padding: 30px; }
        .page-card {
            background: #fff; border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden;
        }
        .page-card-header {
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            padding: 20px 25px; display: flex;
            justify-content: space-between; align-items: center;
        }
        .page-card-header h5 { color: #fff; margin: 0; font-weight: 600; }
        .btn-tambah {
            background: linear-gradient(135deg, #e94560, #c62a47);
            border: none; color: #fff; padding: 8px 20px;
            border-radius: 8px; font-size: 13px; text-decoration: none;
            transition: all 0.3s; display: flex; align-items: center; gap: 7px;
        }
        .btn-tambah:hover { transform: translateY(-1px); color: #fff; }
        .table { margin: 0; }
        .table thead th {
            background: #f8f9fa; color: #555;
            font-size: 13px; font-weight: 600;
            border-bottom: 2px solid #eee; padding: 15px 20px;
        }
        .table tbody td { padding: 15px 20px; vertical-align: middle; font-size: 14px; }
        .table tbody tr:hover { background: #f8f9fa; }
        .avatar-circle {
            width: 35px; height: 35px;
            background: linear-gradient(135deg, #0f3460, #1a6da8);
            border-radius: 50%; display: inline-flex;
            align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 13px; margin-right: 10px;
        }
        .badge-jurusan {
            background: #e8f4fd; color: #0f3460;
            padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .btn-edit {
            background: #fff3cd; color: #856404; border: none;
            padding: 6px 14px; border-radius: 7px; font-size: 12px;
            text-decoration: none; transition: all 0.3s;
        }
        .btn-edit:hover { background: #f5a623; color: #fff; }
        .btn-hapus {
            background: #f8d7da; color: #721c24; border: none;
            padding: 6px 14px; border-radius: 7px; font-size: 12px;
            cursor: pointer; transition: all 0.3s;
        }
        .btn-hapus:hover { background: #e94560; color: #fff; }
        .alert-success {
            background: #d4edda; border: none; color: #155724;
            border-radius: 10px; padding: 12px 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i> Sistem Akademik
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('jurusan.index') }}"><i class="fas fa-building"></i> Jurusan</a></li>
            <li><a href="{{ route('mahasiswa.index') }}" class="active"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="{{ route('matakuliah.index') }}"><i class="fas fa-book"></i> Matakuliah</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h5><i class="fas fa-user-graduate me-2 text-danger"></i>Data Mahasiswa</h5>
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span style="font-size:14px; color:#555;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                </form>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="page-card">
                <div class="page-card-header">
                    <h5><i class="fas fa-user-graduate me-2"></i>Daftar Mahasiswa</h5>
                    <a href="{{ route('mahasiswa.create') }}" class="btn-tambah">
                        <i class="fas fa-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $index => $mahasiswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="avatar-circle">{{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}</span>
                                    <strong>{{ $mahasiswa->nama }}</strong>
                                </td>
                                <td><code>{{ $mahasiswa->nim }}</code></td>
                                <td><span class="badge-jurusan">{{ $mahasiswa->jurusan->nama_jurusan ?? '-' }}</span></td>
                                <td>
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa->id_mahasiswa) }}" class="btn-edit me-1">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', $mahasiswa->id_mahasiswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-hapus"><i class="fas fa-trash me-1"></i>Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data mahasiswa</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>