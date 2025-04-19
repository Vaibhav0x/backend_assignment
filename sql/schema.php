<?php
// require_once '../config/db.php';  # It only work if you run the php inside the sql not from root
require_once __DIR__ . '/../config/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS medications (
    id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS medication_classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT,
    FOREIGN KEY (medication_id) REFERENCES medications(id)
);

CREATE TABLE IF NOT EXISTS medication_class_name (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medication_class_id INT,
    class_name VARCHAR(255),
    FOREIGN KEY (medication_class_id) REFERENCES medication_classes(id)
);

CREATE TABLE IF NOT EXISTS drugs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drug_class_id INT,
    drug_type VARCHAR(255),
    name VARCHAR(255),
    dose VARCHAR(100),
    strength VARCHAR(100),
    FOREIGN KEY (drug_class_id) REFERENCES medication_class_name(id)
);
";

try {
    $pdo->exec($sql);
    echo "Schema imported successfully.";
} catch (PDOException $e) {
    echo "Schema import failed: " . $e->getMessage();
}
