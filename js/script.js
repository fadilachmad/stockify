// Ambil elemen yang dibutuhkan
var keyword = document.getElementById('keyword');
var searchButton = document.getElementById('searchButton');
var container = document.getElementById('container');

// Add event when keyword input
keyword.addEventListener('keyup', function () {
    // Create object AJAX
    var xhr = new XMLHttpRequest();

    // Cek kesiapan AJAX
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText;
        }
    }

    // Eksekusi AJAX
    xhr.open('GET', '../ajax/coba.php?keyword=' + keyword.value, true);
    xhr.send();
});

// Modal Functionality
// Function to open the edit form
function openEditForm(id, name, category, price, quantity, unit, description) {
    document.getElementById('view-id').value = id;
    document.getElementById('view-name').value = name;
    document.getElementById('view-category').value = category;
    document.getElementById('view-price').value = price;
    document.getElementById('view-quantity').value = quantity;
    document.getElementById('view-unit').value = unit;
    document.getElementById('view-description').value = description;

    document.getElementById('edit-form').classList.remove('hidden');
}



// Function to close the edit form
function closeEditForm() {
    document.getElementById('edit-form').classList.add('hidden');
}

// Add event listener to the overlay
document.getElementById('edit-form').addEventListener('click', function (event) {
    // Check if the clicked target is the overlay (not the modal content)
    if (event.target === this) {
        closeEditForm();
    }
});