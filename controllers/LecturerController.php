<?php

// controllers/LecturerController.php

// Sertakan file Model dan View yang kita perlukan
include_once('models/Lecturer.php');
include_once('views/LecturerView.php');

class LecturerController
{
    private $lecturerModel;
    private $lecturerView;

    // Constructor untuk "menyuntikkan" objek Model dan View
    function __construct($model, $view)
    {
        $this->lecturerModel = $model;
        $this->lecturerView = $view;
    }

    // Fungsi untuk menangani tampilan halaman utama
    public function index()
    {
        // 1. Perintahkan Model untuk mengambil semua data dosen
        $data = $this->lecturerModel->getAllLecturers();

        // 2. Perintahkan View untuk menampilkan data tersebut
        $this->lecturerView->renderIndex($data);
    }

    // Fungsi untuk menangani tampilan form create
    public function showCreateForm()
    {
        // Perintahkan View untuk merender form create
        $this->lecturerView->renderCreateForm();
    }

    // Fungsi untuk menangani proses tambah data
    public function storeLecturer()
    {
        // Periksa apakah form disubmit (dari create.html)
        if (isset($_POST['name'])) {
            // 1. Ambil data dari $_POST
            $data = [
                'name' => $_POST['name'],
                'nidn' => $_POST['nidn'],
                'phone' => $_POST['phone'],
                'join_date' => $_POST['join_date']
            ];

            // 2. Perintahkan Model untuk menambah data
            $this->lecturerModel->addLecturer($data);

            // 3. Setelah selesai, kembalikan user ke halaman utama
            header("Location: index.php");
        } else {
            // Jika tidak ada data POST, tampilkan form-nya
            $this->showCreateForm();
        }
    }

    // Fungsi untuk menangani proses hapus data
    public function deleteData()
    {
        // Periksa apakah ada ID di URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // 1. Perintahkan Model untuk menghapus data
            $this->lecturerModel->deleteLecturer($id);

            // 2. Setelah selesai, kembalikan user ke halaman utama
            header("Location: index.php");
        } else {
            // Jika tidak ada ID, kembali ke halaman utama
            header("Location: index.php");
        }
    }

    // Fungsi untuk menangani tampilan form edit
    public function showEditForm()
    {
        // Pastikan ada ID di URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // 1. Minta Model ambil data dosen by ID
            $result = $this->lecturerModel->getLecturerById($id);
            
            // 2. Ambil datanya (fetch)
            // Kita asumsikan ID pasti ketemu
            $data = mysqli_fetch_assoc($result);

            // 3. Perintahkan View untuk tampilkan form dengan data tadi
            $this->lecturerView->renderEditForm($data);
        } else {
            // Jika tidak ada ID, kembali ke index
            header("Location: index.php");
        }
    }

    // Fungsi untuk menangani proses update data
    public function updateData()
    {
        // Pastikan ada ID dari form (input hidden)
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'name' => $_POST['name'],
                'nidn' => $_POST['nidn'],
                'phone' => $_POST['phone'],
                'join_date' => $_POST['join_date']
            ];

            // 1. Perintahkan Model untuk update data
            $this->lecturerModel->updateLecturer($id, $data);

            // 2. Kembali ke halaman utama
            header("Location: index.php");
        } else {
            // Jika tidak ada ID, kembali ke index
            header("Location: index.php");
        }
    }
}

?>
