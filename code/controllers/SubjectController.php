<?php

// controllers/SubjectController.php

// Sertakan file Model dan View yang kita perlukan
include_once('models/Subject.php');
include_once('views/SubjectView.php');
// KITA JUGA BUTUH LECTURER MODEL UNTUK DROPDOWN
include_once('models/Lecturer.php'); 

class SubjectController
{
    private $subjectModel;
    private $subjectView;
    private $lecturerModel; // Properti baru

    // Constructor-nya sekarang menerima 3 parameter
    function __construct($subjectModel, $subjectView, $lecturerModel)
    {
        $this->subjectModel = $subjectModel;
        $this->subjectView = $subjectView;
        $this->lecturerModel = $lecturerModel; // Simpan lecturer model
    }

    // Fungsi untuk halaman utama (list)
    public function index()
    {
        $data = $this->subjectModel->getAllSubjects();
        $this->subjectView->renderSubjectList($data);
    }

    // --- FUNGSI BARU UNTUK MENAMPILKAN FORM ADD ---
    public function showAddForm()
    {
        // 1. Ambil semua data dosen untuk dropdown
        $lecturers = $this->lecturerModel->getAllLecturers();

        // 2. Perintahkan View untuk merender form dengan data dosen
        $this->subjectView->renderAddForm($lecturers);
    }

    // --- FUNGSI BARU UNTUK MEMPROSES FORM ADD ---
    public function storeSubject()
    {
        // Periksa apakah form disubmit
        if (isset($_POST['name'])) {
            // 1. Ambil data dari $_POST
            $data = [
                'name' => $_POST['name'],
                'sks' => $_POST['sks'],
                'lecturer_id' => $_POST['lecturer_id']
            ];

            // 2. Perintahkan Model untuk menambah data subject
            $this->subjectModel->addSubject($data);

            // 3. Kembali ke halaman list subject
            header("Location: index.php?action=subjects");
        } else {
            // Jika tidak ada data POST, tampilkan form-nya
            $this->showAddForm();
        }
    }

    // --- FUNGSI BARU UNTUK MENGHAPUS DATA ---
    public function deleteData()
    {
        // Periksa apakah ada ID di URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // 1. Perintahkan Model untuk menghapus data
            $this->subjectModel->deleteSubject($id);

            // 2. Kembali ke halaman list subject
            header("Location: index.php?action=subjects");
        } else {
            // Jika tidak ada ID, kembali ke halaman list subject
            header("Location: index.php?action=subjects");
        }
    }

    // --- FUNGSI BARU UNTUK MENAMPILKAN FORM EDIT ---
    public function showEditForm()
    {
        // Pastikan ada ID di URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // 1. Ambil data subject yang spesifik by ID
            $subjectResult = $this->subjectModel->getSubjectById($id);
            $subjectData = mysqli_fetch_assoc($subjectResult);

            // 2. Ambil SEMUA data dosen untuk dropdown
            $lecturerData = $this->lecturerModel->getAllLecturers();

            // 3. Perintahkan View untuk render form
            // Kirim DUA data: data subject & data semua dosen
            $this->subjectView->renderEditForm($subjectData, $lecturerData);
        } else {
            // Jika tidak ada ID, kembali ke list subject
            header("Location: index.php?action=subjects");
        }
    }

    // --- FUNGSI BARU UNTUK MEMPROSES FORM UPDATE ---
    public function updateData()
    {
        // Pastikan ada ID dari form (input hidden)
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'name' => $_POST['name'],
                'sks' => $_POST['sks'],
                'lecturer_id' => $_POST['lecturer_id']
            ];

            // 1. Perintahkan Model untuk update data
            $this->subjectModel->updateSubject($id, $data);

            // 2. Kembali ke halaman list subject
            header("Location: index.php?action=subjects");
        } else {
            // Jika tidak ada ID, kembali ke list subject
            header("Location: index.php?action=subjects");
        }
    }

    // ... (kode penutup class) ...
}
?>
