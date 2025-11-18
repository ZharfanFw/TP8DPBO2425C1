# Sistem Manajemen Dosen dan Mata Kuliah (PHP Native MVC)

## Janji

Saya Zharfan Faza Wibawa dengan NIM 24039952403995 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Deskripsi

Program ini adalah program CRUD (Create, Read, Update, Delete) untuk data **Dosen (Lecturers)** dan **Mata Kuliah (Subjects)**. Program ini dibangun menggunakan implementasi dari arsitektur Model-View-Controller (MVC) dalam PHP Native. Program ini juga menerapkan konsep OOP (Object-Oriented Programming) dan menggunakan database MySQL untuk menyimpan data.

## Struktur Database

Terdapat 2 tabel utama dalam database `tp_mvc25` yang digunakan dalam aplikasi ini:

1.  **`lecturers`**, yang berisi data dosen.
2.  **`subjects`**, yang berisi data mata kuliah dan menggunakan relasi _one-to-many_ dengan tabel `lecturers` (melalui _foreign key_ `lecturer_id`).

## Struktur Desain Program

Program ini menggunakan arsitektur Model-View-Controller (MVC) dan konsep OOP (Object-Oriented Programming). Berikut adalah penjelasan tentang struktur desain program:

### 1. **Model**

- Model bertanggung jawab untuk mengelola data aplikasi dan berinteraksi dengan database.
- File model diletakkan di dalam folder `models/`.
- Terdapat Class `DB.php` yang berfungsi sebagai _wrapper_ (pembungkus) untuk koneksi database.
- Terdapat juga class `Lecturer.php` dan `Subject.php` yang mengelola data untuk tabelnya masing-masing.
- Model-model ini **tidak mewarisi** class `DB`, melainkan menggunakan _Composition_. Objek `DB` di-inject (disuntikkan) ke dalam model melalui `__construct()`.

### 2. **View (dan Template)**

- Bagian tampilan dipisah menjadi dua folder untuk memisahkan logika tampilan dari HTML murni:
- **`views/`**: Berisi _class_ logika untuk tampilan (misal: `LecturerView.php`, `SubjectView.php`). Class ini dipanggil oleh Controller. Tugasnya adalah mengambil data (yang diberikan Controller), memprosesnya (misal: _looping_ untuk membuat baris tabel), dan memuat file template.
- **`templates/`**: Berisi file `.html` murni (misal: `index.html`, `subjects.html`). File-file ini berisi _placeholder_ (seperti `{{DATA_ROWS}}` atau `{{LECTURER_OPTIONS}}`) yang akan diisi oleh _class_ View.
- Terdapat juga class `Template.php` di dalam `views/` yang berfungsi sebagai "mesin" untuk memuat file template dan mengganti _placeholder_-nya.

### 3. **Controller**

- Controller bertanggung jawab sebagai "manajer" yang menghubungkan Model dan View.
- File controller diletakkan di dalam folder `controllers/`.
- Terdapat `LecturerController.php` dan `SubjectController.php` yang menangani semua logika bisnis dan alur program.
- Controller menerima input dari pengguna (melalui `action` di URL), meminta data ke **Model**, dan kemudian memberikan data tersebut ke **View** untuk ditampilkan.

### 4. **Database**

- Database yang digunakan adalah MySQL.
- File `tp_mvc25.sql` berisi perintah SQL untuk membuat tabel `lecturers` dan `subjects`.

### 5. **Assets**

- Folder `assets/` berisi file-file tambahan seperti Bootstrap CSS dan JS untuk mempercantik tampilan.

### 6. **Front Controller**

- File `index.php` di _root_ direktori berfungsi sebagai **Front Controller** atau Pintu Masuk Utama. Semua permintaan (request) masuk melalui file ini.

## Penjelasan Alur Program

### 1. **Pemilihan Opsi (Routing)**

- `index.php` berfungsi sebagai penerima semua permintaan.
- Format URL yang digunakan adalah `index.php?action=nama_action&id=id_data`.
- `index.php` akan memeriksa nilai `$_GET['action']`.
- Jika `action` berhubungan dengan _subject_ (misal: `action=subjects`, `action=add_subject_form`), maka `index.php` akan membuat `SubjectController`.
- Jika tidak (termasuk `action=index` atau tidak ada `action`), maka `index.php` akan membuat `LecturerController` sebagai _default_.

### 2. **Cara Kerja Controller**

- **Index** (cth: `action=index` atau `action=subjects`), controller akan memanggil method `model->getAll...()` untuk mengambil semua data. Kemudian, controller memanggil method `view->render...List()` sambil memberikan data tersebut.
- **Create** (cth: `action=create` atau `action=add_subject_form`), controller akan memanggil method `view->render...Form()`.
  - Khusus `SubjectController`, ia juga akan memanggil `lecturerModel->getAllLecturers()` untuk mendapatkan data dosen yang akan dimasukkan ke _dropdown_.
- **Store** (cth: `action=store` atau `action=store_subject`), controller akan mengambil data dari `$_POST`, memasukannya ke `model->add...()`, lalu mengarahkan (redirect) pengguna kembali ke halaman _list_.
- **Edit** (cth: `action=edit`), controller mengambil `$_GET['id']`, memanggil `model->get...ById()`, lalu memanggil `view->renderEditForm()` sambil memberikan data yang didapat.
- **Update** (cth: `action=update`), controller mengambil data dari `$_POST` (termasuk `id`), memanggil `model->update...()`, lalu _redirect_ kembali ke halaman _list_.
- **Delete** (cth: `action=delete`), controller mengambil `$_GET['id']`, memanggil `model->delete...()`, lalu _redirect_ kembali ke halaman _list_.

### 3. **Cara Kerja Model**

- Model berisi fungsi-fungsi untuk berinteraksi dengan database (CRUD).
- Contoh: `getAllLecturers()`, `getLecturerById($id)`, `addLecturer($data)`, `updateLecturer($id, $data)`, `deleteLecturer($id)`.
- Model `Subject.php` menggunakan `JOIN` pada method `getAllSubjects()` untuk mengambil nama dosen, tidak hanya `lecturer_id`.
- Model menggunakan _class_ `DB.php` untuk mengeksekusi _query_.

### 4. **Cara Kerja View**

- View dipanggil oleh Controller.
- Contoh alur: `Controller` memanggil `LecturerView->renderIndex($data)`.
- Di dalam `renderIndex()`, `LecturerView` akan:
  1.  Melakukan _looping_ pada `$data` untuk mengubahnya menjadi baris-baris HTML (`<tr>...</tr>`).
  2.  Membuat objek `Template` baru: `$view = new Template('templates/index.html');`.
  3.  Mengisi _placeholder_: `$view->setData('DATA_ROWS', $baris_html);`.
  4.  Menampilkan ke pengguna: `$view->render();`.

## Cara Menjalankan

1.  Pastikan Anda memiliki server lokal seperti XAMPP atau Laragon.
2.  Letakkan folder proyek ini di dalam direktori `htdocs` (untuk XAMPP) atau `www` (untuk Laragon).
3.  Buka `phpmyadmin` dan _import_ file `tp_mvc25.sql` untuk membuat database dan tabelnya.
4.  Sesuaikan konfigurasi database (username, password) di dalam file `config.php` jika diperlukan.
5.  Akses aplikasi melalui browser dengan URL seperti `http://localhost/nama_folder_proyek_kamu/`.

## Dokumentasi
