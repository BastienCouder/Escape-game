<?php 
require_once "./src/dbConnect.php";
//fonction read
function read($table, $searchTerm = null) {
    global $connection;
    try {
        if ($table) {
            $query = "SELECT * FROM $table";
            if (!is_null($searchTerm)) {
                $query .= " WHERE name LIKE :searchTerm OR surname LIKE :searchTerm";
            }
            $statement = $connection->prepare($query);

            if (!is_null($searchTerm)) {
                $searchTerm = '%' . $searchTerm . '%';
                $statement->bindParam(':searchTerm', $searchTerm);
            }

            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } else {
            throw new Exception("Table manquante");
        }
    } catch(Exception $e) {
        echo 'Message: ' . $e->getMessage();
        var_dump($e);
    }
}

//fonction create 
function create($table, $data) {
    global $connection;
    try {
        if (!empty($table) && !empty($data)) {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            
            $statement = $connection->prepare($query);
            
            foreach ($data as $key => $value) {
                $statement->bindValue(':' . $key, $value);
            }
            
            $statement->execute();
        } else {
            throw new Exception("Table ou données manquantes");
        }
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
}

//fonction delete
function delete($table,$id){
    global $connection;
    try {
        if ($table &&  $id) {
            $statement = $connection->prepare("DELETE FROM $table WHERE id = ?");
            $statement->bindParam(1, $id);
            $statement->execute();

        } else {
            throw new Exception("Table ou id manquants");
        }
    } catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
    }
}
