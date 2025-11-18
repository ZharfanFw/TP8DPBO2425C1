<?php
// views/SubjectView.php

// Kita masih pakai mesin Template.php yang sama
include_once('views/Template.php');

class SubjectView
{
    // Fungsi untuk menampilkan halaman utama (list mata kuliah)
    public function renderSubjectList($data) // $data = hasil query mysqli_result
    {
        // 1. String kosong untuk menampung baris tabel
        $dataRows = "";

        // 2. Loop data hasil query
        while ($row = mysqli_fetch_assoc($data)) {
            $dataRows .= "<tr>
                <td>{$row['id']}</td>
                <td>{$row['subject_name']}</td>
                <td>{$row['sks']}</td>
                <td>{$row['lecturer_name']}</td>
                <td>
                    <a class='btn btn-warning' href='index.php?action=edit_subject_form&id={$row['id']}'>Edit</a>
                    <a class='btn btn-danger' href='index.php?action=delete_subject&id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }

        // 3. Muat template subjects.html
        $view = new Template('templates/subjects.html');

        // 4. Ganti placeholder {{DATA_SUBJECTS}}
        $view->setData('DATA_SUBJECTS', $dataRows);

        // 5. Tampilkan halaman
        $view->render();
    }
    
    // Fungsi untuk menampilkan form tambah data
    // $lecturerData adalah data semua dosen dari tabel lecturers
    public function renderAddForm($lecturerData)
    {
        // 1. Buat string kosong untuk menampung <option>
        $options = "";

        // 2. Loop data dosen untuk membuat tag <option>
        while ($row = mysqli_fetch_assoc($lecturerData)) {
            $options .= "<option value='{$row['id']}'>{$row['name']}</option>";
        }

        // 3. Muat template add_subject.html
        $view = new Template('templates/add_subject.html');

        // 4. Ganti placeholder {{LECTURER_OPTIONS}}
        $view->setData('LECTURER_OPTIONS', $options);

        // 5. Tampilkan halaman
        $view->render();
    }

    // Fungsi untuk menampilkan form edit data
    // $subjectData adalah 1 baris data subject yang mau diedit
    // $lecturerData adalah data semua dosen
    public function renderEditForm($subjectData, $lecturerData)
    {
        // 1. Ambil data spesifik subject
        $id = $subjectData['id'];
        $name = $subjectData['subject_name'];
        $sks = $subjectData['sks'];
        $currentLecturerId = $subjectData['lecturer_id'];

        // 2. Buat string <option>
        $options = "";
        while ($row = mysqli_fetch_assoc($lecturerData)) {
            // Cek apakah ID dosen ini sama dengan ID dosen yang sedang mengajar
            $selected = ($row['id'] == $currentLecturerId) ? 'selected' : '';
            
            $options .= "<option value='{$row['id']}' {$selected}>
                            {$row['name']}
                         </option>";
        }

        // 3. Muat template edit_subject.html
        $view = new Template('templates/edit_subject.html');

        // 4. Ganti semua placeholder
        $view->setData('ID', $id);
        $view->setData('NAME', $name);
        $view->setData('SKS', $sks);
        $view->setData('LECTURER_OPTIONS', $options);

        // 5. Tampilkan halaman
        $view->render();
    }
}
?>
