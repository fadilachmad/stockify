// Ambil elemen yang dibutuhkan
var keyword = document.getElementById('keyword');
var searchButton = document.getElementById('searchButton');
var container = document.getElementById('container');

// Add event when keyword input
keyword.addEventListener('keyup', function() {
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