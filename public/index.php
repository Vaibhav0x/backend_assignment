<?php
require_once '../config/db.php';
require_once '../models/Medication.php';

$med = new Medication($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    $med->save($data);
    echo json_encode(['message' => 'Data saved successfully']);
} else {
    header("Content-Type: application/json");
    echo json_encode($med->get(), JSON_PRETTY_PRINT);
}
