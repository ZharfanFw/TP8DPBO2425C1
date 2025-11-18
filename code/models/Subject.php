<?php

// models/Subject.php

class Subject
{
    private $db; // Objek koneksi DB
    private $table = 'subjects'; // Nama tabel
    private $lecturerTable = 'lecturers'; // Tabel relasi

    function __construct($db_object)
    {
        $this->db = $db_object;
    }

    // Function untuk mengambil SEMUA data subject
    // Kita pakai JOIN untuk dapat nama dosen-nya
    function getAllSubjects()
    {
        $query = "SELECT 
                    " . $this->table . ".id, 
                    " . $this->table . ".subject_name, 
                    " . $this->table . ".sks, 
                    " . $this->lecturerTable . ".name AS lecturer_name 
                  FROM " . $this->table . "
                  JOIN " . $this->lecturerTable . " 
                    ON " . $this->table . ".lecturer_id = " . $this->lecturerTable . ".id
                  ORDER BY " . $this->table . ".id"; // Urutkan by ID
                  
        return $this->db->execute($query);
    }

    // Function untuk mengambil SATU data subject by ID
    // Ini dipakai untuk mengisi form edit
    function getSubjectById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = $id";
        return $this->db->execute($query);
    }

    // Function untuk menambah data subject
    function addSubject($data)
    {
        $name = $data['name'];
        $sks = $data['sks'];
        $lecturer_id = $data['lecturer_id'];

        $query = "INSERT INTO " . $this->table . " (subject_name, sks, lecturer_id) 
                  VALUES ('$name', '$sks', '$lecturer_id')";
        return $this->db->execute($query);
    }

    // Function untuk update data subject
    function updateSubject($id, $data)
    {
        $name = $data['name'];
        $sks = $data['sks'];
        $lecturer_id = $data['lecturer_id'];

        $query = "UPDATE " . $this->table . " 
                  SET subject_name='$name', sks='$sks', lecturer_id='$lecturer_id' 
                  WHERE id='$id'";
        return $this->db->execute($query);
    }

    // Function untuk hapus data subject
    function deleteSubject($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = $id";
        return $this->db->execute($query);
    }
}

?>
