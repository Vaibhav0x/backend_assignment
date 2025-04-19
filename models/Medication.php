<?php

class Medication {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function save($data) {
        $this->pdo->beginTransaction();

        $this->pdo->exec("INSERT INTO medications () VALUES ()");
        $medId = $this->pdo->lastInsertId();

        foreach ($data['medications'][0]['medicationsClasses'] as $classGroup) {
            $stmt1 = $this->pdo->prepare("INSERT INTO medication_classes (medication_id) VALUES (?)");
            $stmt1->execute([$medId]);
            $medClassId = $this->pdo->lastInsertId();

            foreach ($classGroup as $className => $classEntries) {
                $stmt2 = $this->pdo->prepare("INSERT INTO medication_class_name (medication_class_id, class_name) VALUES (?, ?)");
                $stmt2->execute([$medClassId, $className]);
                $drugClassId = $this->pdo->lastInsertId();

                foreach ($classEntries as $entry) {
                    foreach ($entry as $drugType => $drugList) {
                        foreach ($drugList as $drug) {
                            $stmt3 = $this->pdo->prepare("INSERT INTO drugs (drug_class_id, drug_type, name, dose, strength) VALUES (?, ?, ?, ?, ?)");
                            $stmt3->execute([$drugClassId, $drugType, $drug['name'], $drug['dose'], $drug['strength']]);
                        }
                    }
                }
            }
        }

        $this->pdo->commit();
    }

    // Fetch from DB and build exact JSON
    public function get() {
        $output = ['medications' => []];

        $medications = $this->pdo->query("SELECT id FROM medications")->fetchAll();

        foreach ($medications as $med) {
            $medEntry = ['medicationsClasses' => []];

            $stmt = $this->pdo->prepare("SELECT id FROM medication_classes WHERE medication_id = ?");
            $stmt->execute([$med['id']]);
            $classes = $stmt->fetchAll();

            foreach ($classes as $class) {
                $classEntry = [];

                $stmt = $this->pdo->prepare("SELECT id, class_name FROM medication_class_name WHERE medication_class_id = ?");
                $stmt->execute([$class['id']]);
                $drugClasses = $stmt->fetchAll();

                foreach ($drugClasses as $drugClass) {
                    $stmt = $this->pdo->prepare("SELECT drug_type, name, dose, strength FROM drugs WHERE drug_class_id = ?");
                    $stmt->execute([$drugClass['id']]);
                    $drugs = $stmt->fetchAll();

                    $drugTypeMap = [];
                    foreach ($drugs as $drug) {
                        $drugTypeMap[$drug['drug_type']][] = [
                            'name' => $drug['name'],
                            'dose' => $drug['dose'],
                            'strength' => $drug['strength']
                        ];
                    }

                    $classEntry[$drugClass['class_name']] = [$drugTypeMap];
                }

                $medEntry['medicationsClasses'][] = $classEntry;
            }

            $output['medications'][] = $medEntry;
        }

        return $output;
    }
}
