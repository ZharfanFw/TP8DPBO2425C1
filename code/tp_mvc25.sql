CREATE DATABASE IF NOT EXISTS tp_mvc25;
USE tp_mvc25;

-- =====================================================
-- Table: lecturers
-- =====================================================
CREATE TABLE lecturers (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    nidn VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    join_date DATE NOT NULL
);

-- =====================================================
-- Table: subjects
-- =====================================================
CREATE TABLE subjects (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    subject_name VARCHAR(255) NOT NULL,
    sks INT(2) NOT NULL,
    lecturer_id INT(11) NOT NULL,
    FOREIGN KEY (lecturer_id) REFERENCES lecturers(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =====================================================
-- Insert Data: lecturers
-- =====================================================
INSERT INTO lecturers (name, nidn, phone, join_date) VALUES
('Dr. Iwan K.', '00123456', '0812345678', '2010-05-15'),
('Prof. Budi S.', '00789012', '0876543210', '2005-03-01'),
('Siti Aminah, M.Kom.', '00345678', '0899876543', '2015-09-20');

-- =====================================================
-- Insert Data: subjects
-- =====================================================
INSERT INTO subjects (subject_name, sks, lecturer_id) VALUES
('Desain & Pemrograman Berorientasi Objek', 4, 1),
('Struktur Data', 3, 2),
('Jaringan Komputer', 3, 3),
('Basis Data', 4, 1);
-- =====================================================
