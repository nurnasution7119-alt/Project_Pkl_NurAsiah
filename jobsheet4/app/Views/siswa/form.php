
<?php
$isEdit = isset($siswa);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit' : 'Tambah' ?> Data Siswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background: #198754;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            margin-left: 10px;
            color: #0d6efd;
        }
    </style>
</head>

<body>

<div class="container">
    <h2><?= $isEdit ? 'Edit Data Siswa' : 'Tambah Data Siswa' ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p style="color:red"><?= esc($error) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="post"
          action="<?= $isEdit
              ? base_url('siswa/update/'.$siswa['id'])
              : base_url('siswa/store') ?>">

        <?= csrf_field() ?>

        <label>NIS</label>
        <input type="text" name="nis"
               value="<?= esc(old('nis', $siswa['nis'] ?? '')) ?>" required>

        <label>Nama Siswa</label>
        <input type="text" name="nama"
               value="<?= esc(old('nama', $siswa['nama'] ?? '')) ?>" required>

        <label>Kelas</label>
        <input type="text" name="kelas"
               value="<?= esc(old('kelas', $siswa['kelas'] ?? '')) ?>" required>

        <label>Jurusan</label>
        <input type="text" name="jurusan"
               value="<?= esc(old('jurusan', $siswa['jurusan'] ?? '')) ?>" required>

        <label>Alamat</label>
        <textarea name="alamat" rows="4"><?= esc(old('alamat', $siswa['alamat'] ?? '')) ?></textarea>

        <button type="submit">
            <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Data' ?>
        </button>

        <a href="<?= base_url('siswa') ?>">Kembali</a>
    </form>
</div>

</body>
</html>
