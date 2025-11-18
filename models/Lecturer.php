<?php

// models/Lecturer.php

class Lecturer
{
    private $db; // Properti untuk menyimpan objek koneksi DB
    private $table = 'lecturers'; // Nama tabel

    // Constructor untuk "menyuntikkan" objek DB
    function __construct($db_object)
    {
        $this->db = $db_object;
    }

    // Function untuk mengambil semua data lecturer
    function getAllLecturers()
    {
        // Menyiapkan query
        $query = "SELECT * FROM $this->table";

        // Menjalankan query menggunakan objek DB yang sudah disimpan
        // dan langsung mengembalikan hasilnya
        return $this->db->execute($query);
    }

    // Function untuk mengambil data lecturer (hasil dari execute)
    function getResult()
    {
        // Memanggil getResult dari objek DB
        return $this->db->getResult();
    }

    // Function untuk menambah data lecturer baru
    function addLecturer($data)
    {
        // Ambil data dari array
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        // Siapkan query INSERT
        // Ini adalah query dari create.php lama kamu
        $query = "INSERT INTO $this->table (`name`, `nidn`, `phone`, `join_date`) 
                  VALUES ('$name', '$nidn', '$phone', '$join_date')";

        // Eksekusi query
        return $this->db->execute($query);
    }

    function deleteLecturer($id)
    {
        // Siapkan query DELETE
        $query = "DELETE FROM $this->table WHERE id = $id";

        // Eksekusi query
        return $this->db->execute($query);
    }

    // Function untuk mengambil SATU data lecturer berdasarkan ID
    function getLecturerById($id)
    {
        // Siapkan query
        $query = "SELECT * FROM $this->table WHERE id = $id";

        // Eksekusi query
        return $this->db->execute($query);
    }

    // Function untuk meng-update data lecturer
    function updateLecturer($id, $data)
    {
        // Ambil data dari array
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        // Siapkan query UPDATE
        $query = "UPDATE $this->table 
                  SET name='$name', nidn='$nidn', phone='$phone', join_date='$join_date' 
                  WHERE id='$id'";

        // Eksekusi query
        return $this->db->execute($query);
    }
}

?>
