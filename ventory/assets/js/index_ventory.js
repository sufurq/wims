import axios from 'https://cdn.skypack.dev/axios';
const tableBody = document.querySelector('#tableBody');


async function fetchData(url) {
  try {
    const response = await axios.get(url);
    const data = response.data;

    if (data.error) {
      console.error(data.error);
      return;
    }

    tableBody.innerHTML = '';

    data.forEach(record => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${record.id}</td>
        <td>${record.category}</td>
        <td>${record.item_description}</td>
        <td>${record.unit_of_measure}</td>
        <td>${record.quantity}</td>
        <td>${record.unit_price}</td>
        <td>${record.amount}</td>
        <td class="text-center">
        <button class="edit-btn" onclick="window.location.href='edit_form.html?id=${record.id}'">Edit</button>

          <button class="delete-btn" data-id="${record.id}">Delete</button>
        </td>
        <td class="text-center">
        ${record.status !== 'Pending' ? 
          record.status
          : `
          <select class="form-control status-select" data-id="${record.id}">
            <option disabled selected>${record.status}</option>
            <option data-status="Accept">Accept</option>
            <option data-status="Cancel">Cancel</option>
          </select>
        `}
        </td>
      `;
      tableBody.appendChild(row);
    });

  } catch (error) {
    console.error('Error fetching data:', error);
  }
}


function startAutoReload(url, interval) {
    fetchData(url);

    setInterval(() => {
      fetchData(url); 
    }, interval);
}

// Initial call to auto-reload every 5 seconds
startAutoReload('../api/index_ventory_api.php', 1000);

// document.addEventListener('change', async (e) => {
  
//   if (e.target.classList.contains('status-select')) {
//     const id = e.target.getAttribute('data-id');
//     const selectedOption = e.target.options[e.target.selectedIndex].dataset.status;

//     const confirmAction = confirm(`Are you sure you want to ${selectedOption}?`);
//     if (confirmAction) {
//       try {
//         const response = await axios.post(`../api/status.php`, { id: id,status:selectedOption});
//         alert(response.data.message); 
//         fetchData(); 
//       } catch (error) {
//         alert(error.response?.data?.error || 'An error occurred while updating status.');
//       }
//     }
//   }
// });


// document.addEventListener('click', async (e) => {
//   if (e.target.classList.contains('delete-btn')) {
//     const id = e.target.getAttribute('data-id');
//     const confirmDelete = confirm('Are you sure you want to delete this person?');
//     if (confirmDelete) {
//       try {
//         const response = await axios.post(`../api/delete.php`, { id: id });
//         alert(response.data.message);
//         fetchData(); // Refresh the data
//       } catch (error) {
//         alert(error.response?.data?.error || 'An error occurred while deleting.');
//       }
//     }
//   }
// });