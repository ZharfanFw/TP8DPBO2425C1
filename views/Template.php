<?php

// views/Template.php

class Template
{
    private $templateFile; // Path ke file template
    private $data = [];    // Data untuk mengganti placeholder

    // Constructor untuk mengatur file template
    function __construct($file)
    {
        $this->templateFile = $file;
    }

    // Fungsi untuk mengatur data placeholder
    // Contoh: setData('NAMA_HEADER', 'Daftar Dosen')
    // akan mengganti {{NAMA_HEADER}} dengan 'Daftar Dosen'
    function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    // Fungsi untuk merender template
    function render()
    {
        // 1. Periksa apakah file template ada
        if (file_exists($this->templateFile)) {
            
            // 2. Baca isi file template
            $content = file_get_contents($this->templateFile);

            // 3. Ganti semua placeholder dengan data
            foreach ($this->data as $key => $value) {
                // Mencari placeholder format {{KEY}} dan menggantinya
                $content = str_replace("{{" . $key . "}}", $value, $content);
            }

            // 4. Tampilkan HTML yang sudah diproses
            echo $content;

        } else {
            // Tampilkan error jika file template tidak ditemukan
            echo "Error: Template file not found! ($this->templateFile)";
        }
    }
}

?>
