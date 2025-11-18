<?php
// views/LecturerView.php

// Sertakan mesin template yang sudah kita buat
include_once('views/Template.php');

class LecturerView
{
    // Fungsi untuk menampilkan halaman utama (list dosen)
    public function renderIndex($data) // $data di sini adalah hasil query (mysqli_result)
    {
        // 1. Buat string kosong untuk menampung baris-baris tabel
        $dataRows = "";

        // 2. Loop data hasil query dan ubah jadi baris HTML
        // Ini adalah blok 'while' yang kita ambil dari index.php lama
        while ($row = mysqli_fetch_assoc($data)) {
            $dataRows .= "<tr>
                <th>{$row['id']}</th>
                <td>{$row['name']}</td>
                <td>{$row['nidn']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['join_date']}</td>
                <td>
                    <a class='btn btn-success' href='index.php?action=edit&id={$row['id']}'>Edit</a>
                    <a class='btn btn-danger' href='index.php?action=delete&id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }

        // 3. Muat template index.html
        $view = new Template('templates/index.html');

        // 4. Ganti placeholder {{DATA_ROWS}} dengan baris-baris HTML
        $view->setData('DATA_ROWS', $dataRows);

        // 5. Tampilkan halaman yang sudah jadi
        $view->render();
    }

    // --- KITA AKAN TAMBAH FUNGSI LAIN (FORM, EDIT) DI SINI NANTI ---
    public function renderCreateForm()
    {
        // 1. Muat template create.html
        $view = new Template('templates/create.html');

        // 2. Tampilkan halaman (tidak ada data yang perlu diganti)
        $view->render();
    }

    // Fungsi untuk menampilkan halaman form edit data
    public function renderEditForm($data) // $data di sini adalah 1 baris data dosen
    {
        // 1. Muat template edit.html
        $view = new Template('templates/edit.html');

        // 2. Isi placeholder dengan data dosen yang mau diedit
        $view->setData('ID', $data['id']);
        $view->setData('NAME', $data['name']);
        $view->setData('NIDN', $data['nidn']);
        $view->setData('PHONE', $data['phone']);
        $view->setData('JOIN_DATE', $data['join_date']);

        // 3. Tampilkan halaman
        $view->render();
    }
}
?>
