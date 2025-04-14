<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{


  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    switch ($args['classe']) {
      case 0:
        $ord = "ASC";
        break;
      
      case 1:
        $ord = "DESC";
        break;

      default:
      $ord = "ASC";
        break;
    }
    $result = $mysqli_connection->query("SELECT a.nome, a.cognome, a.classe_id 
                                         FROM alunni a
                                         JOIN classi c 
                                         ON a.classe_id = c.id
                                         WHERE c.id =".$args['classe']."
                                         ORDER BY a.nome $ord");
    $result = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }




  public function show(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $sql = "SELECT * FROM alunni WHERE id=" . $args['id'] . ";";
    $result = $mysqli_connection->query($sql);
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }



  public function create(Request $request, Response $response, $args) {
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = json_decode($request->getBody(), true);
    $nome = $mysqli_connection->real_escape_string($body['Nome']);
    $cognome = $mysqli_connection->real_escape_string($body['Cognome']);
    $c_id = ($args["classe"]);
    if($nome == null || $cognome == null) {
      $response->getBody()->write(json_encode(["error" => "Errore nella creazione dell'alunno, nome o cognome non inseriti"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
    $sql = "INSERT INTO alunni (nome, cognome, classe_id) VALUES ('$nome', '$cognome', $c_id)";
    $result = $mysqli_connection->query($sql);
    
    if ($result) {
        $response->getBody()->write(json_encode(["message" => "Alunno creato correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(201);
    } else {
        $response->getBody()->write(json_encode(["error" => "Errore nella creazione dell'alunno"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
  }

  public function update(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body = json_decode($request->getBody(), true);
    $nome = $mysqli_connection->real_escape_string($body['nome']);
    $cognome = $mysqli_connection->real_escape_string($body['cognome']);
    if($nome == null || $cognome == null) {
      $response->getBody()->write(json_encode(["error" => "Errore nell'aggiornamento dell'alunno, nome o cognome non inseriti"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(500);
    }
    $result = $mysqli_connection->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome' WHERE id =".$args['id']); 

    if ($mysqli_connection->affected_rows > 0) {
        $response->getBody()->write(json_encode(["message" => "Alunno aggiornato correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["error" => "Errore nell'aggiornamento dell'alunno"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(400);
    }
  }



  
  public function delete(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("DELETE FROM alunni WHERE id =".$args['id']);

    if ($mysqli_connection->affected_rows > 0) {
        $response->getBody()->write(json_encode(["message" => "Alunno eliminato correttamente"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["error" => "Errore nell'eliminazione dell'alunno"]));
        return $response->withHeader("Content-type", "application/json")->withStatus(400);
    }
  }


  
}

