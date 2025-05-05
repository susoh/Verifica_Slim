import React, { useState } from 'react';
import './TicTacToe.css';

export default function App() {
  const [showTable, setShowTable] = useState(false);

  const toggleTable = () => {
    setShowTable(!showTable);
  };

  const alunni = [
    {
      "nome": "Ivan",
      "cognome": "Bruno",
      "classe_id": "1"
    },
    {
      "nome": "Claudio",
      "cognome": "Benve",
      "classe_id": "1"
    },
    {
        "nome": "Matteo",
        "cognome": "Ciardi",
        "classe_id": "2"
      }
  ];

  return (
    <div className="App">
      <button onClick={toggleTable}>Show/Hide Alunni Table</button>
      {showTable && (
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Cognome</th>
              <th>Classe ID</th>
            </tr>
          </thead>
          <tbody>
            {alunni.map((alunno, index) => (
              <tr key={index}>
                <td>{alunno.nome}</td>
                <td>{alunno.cognome}</td>
                <td>{alunno.classe_id}</td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}
