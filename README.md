End-Points per le CLASSI:

curl http://localhost:8080/classi
Richiesta:
GET    /classi                 ClassiController:index
Risposta:
Status code: 200   
[{"id": 1, "sezione":"5A", "anno": 2024},  {"id": 2 , "sezione":"5B", "anno": 2024} ...e così via...]

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X GET http://localhost:8080/classi/1
Richiesta:
GET    /classi/id                 ClassiController:index
Risposta:
Status code: 200   
[{"id": id, "sezione":"5A", "anno": 2024}] restituisce i dati realtivi alla classe con id pari a quello passato nella richiesta curl

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X POST http://localhost:8080/classi -H "Content-Type: application/json" -d '{"sezione": "5c", "anno": 2025}'
Richiesta:
POST    /classi (nel body sono contenuti i dati per la creazione inseriti precedentemente nel curl)              ClassiController:create
Risposta:
Status code: 201   
{"message": "Classe creata correttamente"}

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X PUT http://localhost:8080/classi/1 -H "Content-Type: application/json" -d '{"sezione": "5c", "anno": 2025}'
Richiesta:
PUT    /classi  (nel body sono contenuti i dati per l'aggiornamento inseriti precedentemente nel curl)             ClassiController:create
Risposta:
Status code: 201    
{"message": "Classe creata correttamente"}

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X DELETE http://localhost:8080/classi/1
Richiesta:
DELETE    /classi/id           ClassiController:create
Risposta:
Status code: 201    
{"message": "Classe eliminata correttamente"}

-------------------------------------------------------------------------------------------------------------------------------------------------------

=======================================================================================================================================================
End-Points per gli ALUNNI:
=======================================================================================================================================================

curl -X GET http://localhost:8080/alunni/1/1       i numeri sono: il primo per la classe, e il secondo per l'ordinamento 1 = DESC --- 0 = asc
Richiesta:
GET    /alunni/1/1                AlunnoController:index
Risposta
Status code: 200   
[{"id": 1, "nome":"Claudio", "Cognome": "Benvenuti", "classe_id": "1"},  {"id": 2 , "nome":"Ivan", "cognome": "Bruno", "classe_id": "1"} ...e così via per ogni studente]

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X GET http://localhost:8080/alunni/1
Richiesta:
GET    /alunni/id                 AlunniController:index
Risposta:
Status code: 200   
[{"id": id, "sezione":"5A", "anno": 2024}] restituisce i dati realtivi all'alunno con id pari a quello passato nella richiesta curl

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X POST http://localhost:8080/alunni -H "Content-Type: application/json" -d '{"Nome": "Matteo", "Cognome": "Ciardi"}'
Richiesta:
POST    /alunni (nel body sono contenuti i dati per la creazione inseriti precedentemente nel curl)              AlunniController:create
Risposta:
Status code: 201   
{"message": "Studente creato correttamente"}

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X POST http://localhost:8080/alunni -H "Content-Type: application/json" -d '{"Nome": "Matteo", "Cognome": "Ciardi"}'
Richiesta:
PUT    /alunni  (nel body sono contenuti i dati per l'aggiornamento inseriti precedentemente nel curl)             AlunniController:create
Risposta:
Status code: 201    
{"message": "Classe creata correttamente"}

--------------------------------------------------------------------------------------------------------------------------------------------------------

curl -X DELETE http://localhost:8080/alunni/1
Richiesta:
DELETE    /alunni/id           AlunniController:create
Risposta:
Status code: 201    
{"message": "Classe eliminata correttamente"}
