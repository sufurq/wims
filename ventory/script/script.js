function toggleDetails(button) {
    var detailsRow = button.closest('tr').nextElementSibling;
    if (detailsRow.style.display === 'none') {
        detailsRow.style.display = 'table-row';
        button.innerHTML = '-'; // Change button to "-" when expanded
    } else {
        detailsRow.style.display = 'none';
        button.innerHTML = '+'; // Change button to "+" when collapsed
    }
}

function editRecord(id) {
    window.location.href = 'edit_po.php?id=' + id;
}

function deleteRecord(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        window.location.href = 'delete_po.php?id=' + id;
    }
}

// Data for demonstration - In a real scenario, this data comes from the database
const purchaseOrders = [
{ id: 1, poNumber: 'PO123', supplier: 'Supplier A', status: 'pending' },
{ id: 2, poNumber: 'PO124', supplier: 'Supplier B', status: 'partial' },
{ id: 3, poNumber: 'PO125', supplier: 'Supplier C', status: 'deleted' },
{ id: 4, poNumber: 'PO126', supplier: 'Supplier D', status: 'fully-delivered' },
{ id: 5, poNumber: 'PO127', supplier: 'Supplier A', status: 'pending' }
];

// Function to filter results based on search input
document.getElementById('search-input').addEventListener('input', function () {
const searchTerm = this.value.toLowerCase();
const filteredOrders = purchaseOrders.filter(order => 
    order.poNumber.toLowerCase().includes(searchTerm) || 
    order.supplier.toLowerCase().includes(searchTerm)
);

displayResults(filteredOrders);
});

// Function to display filtered results in the dropdown
function displayResults(orders) {
const resultList = document.getElementById('result-list');
resultList.innerHTML = '';  // Clear previous results

if (orders.length > 0) {
    orders.forEach(order => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.innerHTML = `P.O: ${order.poNumber} - ${order.supplier}`;
        resultList.appendChild(li);
    });
    document.getElementById('search-results').style.display = 'block';  // Show results dropdown
} else {
    document.getElementById('search-results').style.display = 'none';  // Hide if no results
}
}

// Initially display all rows
let totalRows = document.querySelectorAll('.purchase-order-row').length;

// Add an event listener to the "entries-count" dropdown to control the number of rows displayed
document.getElementById('entries-count').addEventListener('change', function () {
const numEntries = parseInt(this.value);
const rows = document.querySelectorAll('.purchase-order-row');

// First hide all rows
rows.forEach((row, index) => {
    row.style.display = 'none';
});

// Show only the selected number of rows
for (let i = 0; i < numEntries && i < rows.length; i++) {
    rows[i].style.display = 'table-row';
}
});

// Initially show 10 rows or less depending on the number of rows available
document.getElementById('entries-count').value = Math.min(10, totalRows).toString();
document.getElementById('entries-count').dispatchEvent(new Event('change'));

document.addEventListener('DOMContentLoaded', function() {
    const modalOverlay = document.getElementById('modalOverlay');
    const modal = document.getElementById('modal');
    const newRecordBtn = document.getElementById('newRecordBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeModal = document.getElementById('closeModal');
    
    // Show modal when "New Record" button is clicked
    newRecordBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'block';
        modal.style.display = 'block';
    });

    // Hide modal when the close button or overlay is clicked
    closeModalBtn.addEventListener('click', closeModalFunction);
    closeModal.addEventListener('click', closeModalFunction);
    modalOverlay.addEventListener('click', closeModalFunction);

    function closeModalFunction() {
        modalOverlay.style.display = 'none';
        modal.style.display = 'none';
    }
});



