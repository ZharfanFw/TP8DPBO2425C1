<?php

// index.php - PUSAT KENDALI UTAMA

// 1. Sertakan file konfigurasi dan DB
include_once('config.php');
include_once('models/DB.php');

// 2. Sertakan SEMUA file Model
include_once('models/Lecturer.php');
include_once('models/Subject.php');

// 3. Sertakan SEMUA file View
include_once('views/LecturerView.php');
include_once('views/SubjectView.php');

// 4. Sertakan SEMUA file Controller
include_once('controllers/LecturerController.php');
include_once('controllers/SubjectController.php');

// 5. Buat objek koneksi database
$db = new DB($servername, $username, $password, $db_name);
$db->open(); // Buka koneksi

// 6. Ambil 'action' dari URL
$action = $_GET['action'] ?? 'index'; // Default action = 'index'

// 7. Tentukan Controller mana yang akan dipakai
if (strpos($action, 'subject') !== false || $action == 'subjects') {
    // --- RUTE UNTUK SUBJECT ---
    
    // Buat objek Model Subject
    $model = new Subject($db);
    // Buat objek View Subject
    $view = new SubjectView();
    // BUAT JUGA OBJEK MODEL LECTURER (untuk dropdown)
    $lecturerModel = new Lecturer($db);

    // Kirim SEMUA model yang dibutuhkan ke Controller
    $controller = new SubjectController($model, $view, $lecturerModel);

    // Tentukan aksi untuk SubjectController
    switch ($action) {
        case 'subjects':
            $controller->index();
            break;
        
        case 'add_subject_form': 
            $controller->showAddForm();
            break;
        
        case 'store_subject':
            $controller->storeSubject();
            break;

        case 'delete_subject': 
            $controller->deleteData();
            break;

        case 'edit_subject_form': 
            $controller->showEditForm();
            break;

        case 'update_subject': 
            $controller->updateData();
            break;
        
        default:
            $controller->index();
            break;
    }
} else {
    // --- RUTE UNTUK LECTURER (DEFAULT) ---
    
    // Buat objek MVC untuk Lecturer
    $model = new Lecturer($db);
    $view = new LecturerView();
    $controller = new LecturerController($model, $view);

    // Tentukan aksi untuk LecturerController
    switch ($action) {
        case 'index':
            $controller->index();
            break;
        case 'create':
            $controller->showCreateForm();
            break;
        case 'store':
            $controller->storeLecturer();
            break;
        case 'delete':
            $controller->deleteData();
            break;
        case 'edit':
            $controller->showEditForm();
            break;
        case 'update':
            $controller->updateData();
            break;
        default:
            $controller->index();
            break;
    }
}

// 8. Tutup koneksi database
$db->close();

?>
