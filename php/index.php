<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/ClassiController.php';

$app = AppFactory::create();

//curl -X GET http://localhost:8080/alunni/1/1
$app->get('/alunni/{classe}/{order_by}', "AlunniController:index");

//curl -X GET http://localhost:8080/alunni/1
$app->get('/alunni/{id}', "AlunniController:show");

//curl -X POST http://localhost:8080/alunni/1 -H "Content-Type: application/json" -d '{"Nome": "matteo", "Cognome": "Ciardi"}'
// Crea un nuovo alunno
$app->post('/alunni/{classe}', "AlunniController:create");

// Aggiorna un alunno esistente
$app->put('/alunni/{id}', "AlunniController:update");

// Elimina un alunno
$app->delete('/alunni/{id}', "AlunniController:delete");

//Ora ci sono le rotte per le classi

//curl -X GET http://localhost:8080/classi
$app->get('/classi', "ClassiController:index"); 

//curl -X GET http://localhost:8080/classi/1
$app->get('/classi/{id}', "ClassiController:show");

//curl -X POST http://localhost:8080/classi -H "Content-Type: application/json" -d '{"sezione": "5c", "anno": 2025}'
$app->post('/classi', "ClassiController:create");

//curl -X PUT http://localhost:8080/classi/1 -H "Content-Type: application/json" -d '{"sezione": "5c", "anno": 2025}'
$app->put('/classi/{id}', "ClassiController:update");

//curl -X DELETE http://localhost:8080/classi/1
$app->delete('/classi/{id}', "ClassiController:delete");

$app->run();




?>