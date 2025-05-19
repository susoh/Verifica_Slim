import React, { useState, useEffect } from 'react';
import './TicTacToe.css';

export default function App() {
  const [showTable, setShowTable] = useState(true); // By default show the table
  const [alunni, setAlunni] = useState([]);
  const [newAlunno, setNewAlunno] = useState({ nome: '', cognome: '' });
  const [editingAlunno, setEditingAlunno] = useState(null); // Tracking the alunno being edited
  const classe = 1; // Classe hardcoded for example
  const orderBy = 1; // Ordine (ASC=0, DESC=1)

  // Fetch alunni (students) on component mount
  useEffect(() => {
    fetch(`http://localhost:8080/alunni/${classe}/${orderBy}`)
      .then(response => response.json())
      .then(data => setAlunni(data))
      .catch(error => console.error('Error fetching data:', error));
  }, [classe, orderBy]);

  // Toggle visibility of the table
  const toggleTable = () => {
    setShowTable(!showTable);
  };

  // Handle form submission (for new alunno)
  const handleSubmit = (event) => {
    event.preventDefault();
    
    const url = editingAlunno ? `http://localhost:8080/alunni/${editingAlunno.id}` : `http://localhost:8080/alunni/${classe}`;
    const method = editingAlunno ? 'PUT' : 'POST'; // Use PUT if we're editing an alunno
    const headers = {
      'Content-Type': 'application/json',
    };
    const body = JSON.stringify({
      nome: newAlunno.nome,
      cognome: newAlunno.cognome,
    });

    fetch(url, {
      method,
      headers,
      body,
    })
      .then(response => response.json())
      .then(data => {
        if (editingAlunno) {
          setAlunni((prevState) =>
            prevState.map((alunno) => (alunno.id === editingAlunno.id ? data : alunno))
          ); // Update the existing alunno
        } else {
          setAlunni((prevState) => [...prevState, data]); // Add the new alunno
        }
        setNewAlunno({ nome: '', cognome: '' }); // Reset form fields
        setEditingAlunno(null); // Reset editing state
      })
      .catch(error => console.error('Error submitting alunno:', error));
  };

  // Handle input field changes
  const handleChange = (event) => {
    const { name, value } = event.target;
    setNewAlunno((prevState) => ({
      ...prevState,
      [name]: value,
    }));
  };

  // Handle delete alunno
  const handleDelete = (id) => {
    const url = `http://localhost:8080/alunni/${id}`;
    fetch(url, {
      method: 'DELETE',
    })
      .then(response => {
        if (response.ok) {
          // Remove alunno from the list after successful delete
          setAlunni((prevState) => prevState.filter((alunno) => alunno.id !== id));
        } else {
          console.error('Error deleting alunno:', response.statusText);
        }
      })
      .catch(error => console.error('Error deleting alunno:', error));
  };

  // Handle edit alunno
  const handleEdit = (id) => {
    const alunnoToEdit = alunni.find((alunno) => alunno.id === id);
    setNewAlunno({ nome: alunnoToEdit.nome, cognome: alunnoToEdit.cognome });
    setEditingAlunno(alunnoToEdit); // Set the alunno being edited
  };

  return (
    <div className="App">
      <button onClick={toggleTable}>
        {showTable ? 'Hide Alunni Table' : 'Show Alunni Table'}
      </button>

      {showTable && (
        <div>
          <table className="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {alunni.length === 0 ? (
                <tr>
                  <td colSpan="3">No alunni found</td>
                </tr>
              ) : (
                alunni.map((alunno, index) => (
                  <tr key={index}>
                    <td>{alunno.nome}</td>
                    <td>{alunno.cognome}</td>
                    <td>
                      <button onClick={() => handleEdit(alunno.id)}>Edit</button>
                      <button onClick={() => handleDelete(alunno.id)}>Delete</button>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>

          <div className="form-container">
            <h3>{editingAlunno ? 'Modifica Alunno' : 'Inserisci Nuovo Alunno'}</h3>
            <form onSubmit={handleSubmit}>
              <label>
                Nome:
                <input 
                  type="text" 
                  name="nome" 
                  value={newAlunno.nome} 
                  onChange={handleChange} 
                  required 
                />
              </label>
              <br />
              <label>
                Cognome:
                <input 
                  type="text" 
                  name="cognome" 
                  value={newAlunno.cognome} 
                  onChange={handleChange} 
                  required 
                />
              </label>
              <br />
              <button type="submit">
                {editingAlunno ? 'Salva Modifiche' : 'Inserisci Nuovo Alunno'}
              </button>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
