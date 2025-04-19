# Medication API - PHP Backend Assignment Project

This project provides an API to store and retrieve medication data in a nested JSON format using PHP and MySQL.

## Tech Stack

- PHP 
- MySQL
- Postman (for testing)

---

## Getting Started

Follow the steps below to set up the project locally and run it successfully.
- First ensure MySQL server and Apache running using XAMPP server.

### 1. Clone the Repository

```bash
git clone https://github.com/Vaibhav0x/backend_assignment.git
cd backend_assignment
```

### 2 To create the database and table using schema.php

```bash
php sql/schema.php
```

Database and Tables are created in your sql.

### 3 TO run the api
```bash
php -S localhost:8000 -t public
```

### Test the API using Postman

- 1. Method **GET** `http://localhost:8000/`

To get the data from the tables and shown in json format.

- 2. Method **POST** `http://localhost:8000/`

- 3. To Post the data using body in raw json format data looks like:

```json
{
    "medications": [
        {
            "medicationsClasses": [
                {
                    "className": [
                        {
                            "associatedDrug": [
                                {
                                    "dose": "",
                                    "name": "asprin",
                                    "strength": "500 mg"
                                }
                            ],
                            "associatedDrug#2": [
                                {
                                    "dose": "",
                                    "name": "somethingElse",
                                    "strength": "500 mg"
                                }
                            ]
                        }
                    ],
                    "className2": [
                        {
                            "associatedDrug": [
                                {
                                    "dose": "",
                                    "name": "asprin",
                                    "strength": "500 mg"
                                }
                            ],
                            "associatedDrug#2": [
                                {
                                    "dose": "",
                                    "name": "somethingElse",
                                    "strength": "500 mg"
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
```
