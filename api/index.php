<?php

require 'Slim/Slim.php';
include('fields.php'); //$feilds_arr,$fields_str,$fields_val,$fields_update

$app = new Slim();

$app->get('/wines', 'getWines');
$app->get('/wines/:id', 'getWine');
$app->get('/wines/search/:query', 'findByName');
$app->post('/wines', 'addWine');
$app->put('/wines/:id', 'updateWine');
$app->delete('/wines/:id', 'deleteWine');

$app->run();

function getWines() {
    $sql = "select * FROM wine ORDER BY name";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        // echo '{"wine": ' . json_encode($wines) . '}';
        echo json_encode($wines);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getWine($id) {
    $sql = "SELECT * FROM wine WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $wine = $stmt->fetchObject();
        $db = null;
        echo json_encode($wine);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addWine() {
    error_log('addWine\n', 3, '/php.log');
    $request = Slim::getInstance()->request();
    $wine = json_decode($request->getBody());
    global $fields_val,$fields_arr;
    $sql = "INSERT INTO wine VALUES (NULL," . $fields_val . ")";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        foreach ($fields_arr as $key) {
            $stmt->bindParam($key, $wine->$key);
        }
        $stmt->execute();
        $wine->id = $db->lastInsertId();
        $db = null;
        echo json_encode($wine);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function updateWine($id) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $wine = json_decode($body);
      global $fields_update,$fields_arr;
      //echo $fields_update;
    $sql = "UPDATE wine SET " . $fields_update . " WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        foreach ($fields_arr as $key) {
            $stmt->bindParam($key, $wine->$key);
        }
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($wine);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function deleteWine($id) {
    $sql = "DELETE FROM wine WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function findByName($query) {
    $sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($wines);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "cellar";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>