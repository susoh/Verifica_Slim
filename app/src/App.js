import React, { useState, useEffect } from 'react';
import './TicTacToe.css';

export default function App() {
  const [showTable, setShowTable] = useState(false);
  const [alunni, setAlunni] = useState([]);

  useEffect(() => {
    fetch('http://localhost:8080/alunni/1/1') // Adjust the URL as needed
      .then(response => response.json())
      .then(data => setAlunni(data))
      .catch(error => console.error('Error fetching data:', error));
  }, []);

  const toggleTable = () => {
    setShowTable(!showTable);
  };

  return (
    <div className="App">
      <button onClick={toggleTable}>Show/Hide Alunni Table</button>
      {showTable && (
        <table className="table">
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

