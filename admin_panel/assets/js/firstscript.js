document.getElementById('openModal').onclick = function() {
    document.getElementById('orderModal').style.display = 'block';
}

document.getElementById('closeModal').onclick = function() {
    document.getElementById('orderModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('orderModal')) {
        document.getElementById('orderModal').style.display = 'none';
    }
}

document.getElementById('orderForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent form submission

    const formData = new FormData(this);

    // Send data to the server
    fetch('submit_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Order submitted successfully!');
        document.getElementById('orderModal').style.display = 'none';
        this.reset(); // Reset form fields
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting your order.');
    });
}
