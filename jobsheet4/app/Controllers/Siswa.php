<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
{
    // Menampilkan data siswa dengan pagination
    public function index()
    {
        $model = new SiswaModel();

        $data['siswa'] = $model
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $data['pager'] = $model->pager;

        return view('siswa/index', $data);
    }

    // Halaman tambah siswa
    public function create()
    {
        return view('siswa/form');
    }

    // Menyimpan data siswa
    public function store()
    {
        $rules = [
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new SiswaModel();

        $model->save([
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/siswa')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Halaman edit siswa
    public function edit($id)
    {
        $model = new SiswaModel();

        $data['siswa'] = $model->find($id);

        if (!$data['siswa']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('siswa/form', $data);
    }

    // Memperbarui data siswa
    public function update($id)
    {
        $rules = [
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new SiswaModel();

        if (!$model->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $model->update($id, [
            'nis' => $this->request->getPost('nis'),
            'nama' => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
            'jurusan' => $this->request->getPost('jurusan'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/siswa')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Pencarian siswa menggunakan Query Builder
    public function search()
    {
        $keyword = trim($this->request->getGet('keyword') ?? '');

        $model = new SiswaModel();

        if ($keyword === '') {
            $result = $model
                ->orderBy('id', 'DESC')
                ->findAll();
        } else {
            $result = $model
                ->groupStart()
                    ->like('nis', $keyword)
                    ->orLike('nama', $keyword)
                    ->orLike('kelas', $keyword)
                    ->orLike('jurusan', $keyword)
                ->groupEnd()
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        return $this->response->setJSON($result);
    }

    // Menghapus data siswa
    public function delete($id)
    {
        $model = new SiswaModel();

        if (!$model->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $model->delete($id);

        return redirect()->to('/siswa')
            ->with('success', 'Data siswa berhasil dihapus!');
    }
}
