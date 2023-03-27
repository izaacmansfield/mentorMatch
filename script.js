async function fetchData() {
  const response = await fetch('retrieve_data.php');
  const data = await response.json();
  displayData(data);
}

function displayData(data) {
  const tableBody = document.getElementById('table-body');
  tableBody.innerHTML = '';

  data.forEach(row => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${row.id}</td>
      <td>${row.name}</td>
      <td>${row.email}</td>
    `;
    tableBody.appendChild(tr);
  });
}
