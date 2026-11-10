
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Data Siswa</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        h2 {
            margin-top: 0;
            color: #263b64;
        }

        .search {
            width: 100%;
            max-width: 400px;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .btn-edit {
            background: #e5a000;
            color: white;
            padding: 7px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 7px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 11px;
            text-align: left;
        }

        th {
            background: #263b64;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        @media (max-width: 700px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
                overflow-x: auto;
            }

            table {
                min-width: 750px;
            }
        }

/* Tampilan Pagination */
#pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 25px;
    flex-wrap: wrap;
}

#pagination nav {
    width: 100%;
}

#pagination ul {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}

#pagination li {
    margin: 0;
}

#pagination a,
#pagination strong {
    display: inline-block;
    min-width: 38px;
    padding: 10px 14px;
    text-align: center;
    text-decoration: none;
    border: 1px solid #dce2ed;
    border-radius: 8px;
    color: #263b64;
    background: white;
    font-size: 14px;
    font-weight: bold;
}

#pagination a:hover {
    background: #263b64;
    color: white;
}

#pagination strong {
    background: #263b64;
    color: white;
    border-color: #263b64;
}

    </style>
</head>

<body>

<div class="container">

    <h2>Data Siswa</h2>
    <p>Aplikasi Pengelolaan Data Siswa</p>

    <a href="<?= base_url('siswa/create') ?>" class="btn">
        + Tambah Siswa
    </a>

    <br>

    <input
        type="text"
        id="keyword"
        class="search"
        placeholder="Cari NIS, nama, kelas, atau jurusan..."
    >

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="tabel-siswa">
            <?php $no = 1; ?>

            <?php foreach ($siswa as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nis']) ?></td>
                    <td><?= esc($row['nama']) ?></td>
                    <td><?= esc($row['kelas']) ?></td>
                    <td><?= esc($row['jurusan']) ?></td>
                    <td><?= esc($row['alamat'] ?? '') ?></td>
                    <td>
                        <a
                            href="<?= base_url('siswa/edit/' . $row['id']) ?>"
                            class="btn-edit"
                        >Edit</a>

                        <a
                            href="<?= base_url('siswa/delete/' . $row['id']) ?>"
                            class="btn-delete tombol-hapus"
                        >Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div id="pagination" style="margin-top: 20px;">
        <?= $pager->links() ?>
    </div>

</div>

<script>
$(document).ready(function () {

    // Pencarian menggunakan jQuery AJAX
    $('#keyword').on('keyup', function () {

        const keyword = $(this).val();

        $.ajax({
            url: "<?= base_url('siswa/search') ?>",
            type: "GET",
            data: { keyword: keyword },
            dataType: "json",

            success: function (data) {

                let rows = '';

                if (data.length > 0) {

                    $.each(data, function (i, row) {

                        const nis = $('<div>').text(row.nis).html();
                        const nama = $('<div>').text(row.nama).html();
                        const kelas = $('<div>').text(row.kelas).html();
                        const jurusan = $('<div>').text(row.jurusan).html();
                        const alamat = $('<div>').text(row.alamat ?? '').html();

                        rows += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${nis}</td>
                                <td>${nama}</td>
                                <td>${kelas}</td>
                                <td>${jurusan}</td>
                                <td>${alamat}</td>
                                <td>
                                    <a href="<?= base_url('siswa/edit/') ?>${row.id}"
                                       class="btn-edit">Edit</a>

                                    <a href="<?= base_url('siswa/delete/') ?>${row.id}"
                                       class="btn-delete tombol-hapus">Hapus</a>
                                </td>
                            </tr>
                        `;
                    });

                } else {
                    rows = `
                        <tr>
                            <td colspan="7" style="text-align:center">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    `;
                }

                $('#tabel-siswa').html(rows);
            },

            error: function () {
                Swal.fire('Gagal', 'Pencarian tidak berhasil.', 'error');
            }
        });
    });

    // Konfirmasi penghapusan dengan SweetAlert
    $(document).on('click', '.tombol-hapus', function (e) {

        e.preventDefault();

        const url = $(this).attr('href');

        Swal.fire({
            title: 'Hapus data siswa?',
            text: 'Data yang dihapus tidak dapat ditampilkan kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = url;
            }

        });
    });

    // Notifikasi setelah tambah, edit, atau hapus
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: <?= json_encode(session()->getFlashdata('success')) ?>,
            icon: 'success'
        });
    <?php endif; ?>

});
</script>

</body>
</html>
