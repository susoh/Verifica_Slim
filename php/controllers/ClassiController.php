<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClassiController
{


  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM classi");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }




  public function show(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM classi WHERE id =".$args['id']);
    $result = $result->fetch_assoc();

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }



  public function create(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = json_decode($request->getBody(), true);
    $sezione = $mysqli_connection->real_escape_string($body['sezione']);
    $anno = $mysqli_connection->real_escape_string($body['anno']);
    if($sezione == null || $anno == null) {
        $response->getBody()->write(json_encode(["error" => "Errore nella creazione della classe, sezione o anno non inseriti"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
    $sql = "INSERT INTO classi (sezione, anno) VALUES ('$sezione', $anno);";
    $result = $mysqli_connection->query($sql);
    
    if ($result) {
        $response->getBody()->write(json_encode(["message" => "Classe creata correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(201);
    } else {
    $response->getBody()->write(json_encode(["error" => "Errore nella creazione della classe"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
  }




  public function update(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = json_decode($request->getBody(), true);
    $sezione = $mysqli_connection->real_escape_string($body['sezione']);
    $anno = $mysqli_connection->real_escape_string($body['anno']);
    if($sezione == null || $anno == null) {
        $response->getBody()->write(json_encode(["error" => "Errore nell'aggiornamento della classe, sezione o anno non inseriti"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
    $result = $mysqli_connection->query("UPDATE classi SET sezione = '$sezione', anno = '$anno' WHERE id =".$args['id']); 

    if ($mysqli_connection->affected_rows > 0) {
        $response->getBody()->write(json_encode(["message" => "Classe aggiornata correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["error" => "Errore nell'aggiornamento della classe" . var_dump($body)]));
        return $response->withHeader("Content-type", "application/json")->withStatus(400);
    }
  }



  
  public function delete(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $sql = "DELETE FROM classi WHERE id = ".$args['id'];
    $result = $mysqli_connection->query($sql);
    if ($mysqli_connection->affected_rows > 0) {
        $response->getBody()->write(json_encode(["message" => "Classe eliminata correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["error" => "Errore nell'eliminazione della classe"] . var_dump($sql)));
        return $response->withHeader("Content-type", "application/json")->withStatus(400);
    }
  }


  
}

