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

//onction read by Id
function readById($table, $id) {
    global $connection;
    try {
        if ($table && $id !== null) {
            $query = "SELECT * FROM $table WHERE id = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Table ou ID manquant");
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

//fonction update
function update($table, $id, $data) {
    global $connection;
    $query = "UPDATE $table SET ";
    $params = array();

    foreach ($data as $key => $value) {
        $query .= "`$key` = ?, ";
        $params[] = $value;
    }

    $query = rtrim($query, ', ');

    $query .= " WHERE id = ?";
    $params[] = $id;

    $statement = $connection->prepare($query);

    for ($i = 1; $i <= count($params); $i++) {
        $statement->bindValue($i, $params[$i - 1]);
    }

    $statement->execute();
}

function sortData($data) {
    $sortOrder = $_SESSION['sortOrder'] ?? 'asc';

    usort($data, function($a, $b) use ($sortOrder) {
        $a_percentage = $a['nbr_attempts'] > 0 ? $a['nbr_success'] / $a['nbr_attempts'] : 0;
        $b_percentage = $b['nbr_attempts'] > 0 ? $b['nbr_success'] / $b['nbr_attempts'] : 0;
        
        if ($sortOrder === 'asc') {
            return $a_percentage <=> $b_percentage;
        } else {
            return $b_percentage <=> $a_percentage;
        }
    });

    return $data;
}


function calculateSuccessRate($answer) {
    if (isset($answer['nbr_attempts']) && $answer['nbr_attempts'] > 0) {
        return round(($answer['nbr_success'] / $answer['nbr_attempts']) * 100, 2);
    }
    return 0;
}