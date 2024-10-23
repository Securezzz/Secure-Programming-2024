let donationData = {};

document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();

    const products = [];
    document.querySelectorAll('#product-list .product-item').forEach(item => {
        const productName = item.querySelector('input[name="product-name"]').value;
        const productQuantity = item.querySelector('input[name="product-quantity"]').value;
        products.push({ name: productName, quantity: productQuantity });
    });

    donationData = {
        senderName: document.getElementById('sender-name').value,
        receiverName: document.getElementById('receiver-name').value,
        receiverAddress: document.getElementById('receiver-address').value,
        products: products,
        expiryDate: document.getElementById('expiry-date').value,
        deliveryDate: document.getElementById('delivery-date').value,
        message: document.getElementById('message').value,
    };

    $('#qrisModal').modal('show');
});

document.getElementById('confirmPayment').addEventListener('click', function() {
    const donationRow = document.createElement('tr');
    donationRow.innerHTML = `
        <td>${donationData.senderName}</td>
        <td>${donationData.receiverName}</td>
        <td>${donationData.receiverAddress}</td>
        <td>${donationData.products.map(p => `${p.name} (${p.quantity})`).join(', ')}</td>
        <td>${donationData.expiryDate}</td>
        <td>${donationData.deliveryDate}</td>
        <td>${donationData.message}</td>
    `;

    document.getElementById('donations').appendChild(donationRow);

    $('#qrisModal').modal('hide');
    document.getElementById('form').reset();
    document.getElementById('product-list').innerHTML = `
        <div class="product-item mb-2 input-group">
            <input type="text" class="form-control mb-2" name="product-name" placeholder="Nama Produk" required>
            <input type="number" class="form-control mb-2" name="product-quantity" placeholder="Kuantitas" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-product">Hapus</button>
            </div>
        </div>
    `;
    attachRemoveProductEvent();
});

document.getElementById('add-product').addEventListener('click', function() {
    const productItem = document.createElement('div');
    productItem.classList.add('product-item', 'mb-2', 'input-group');
    productItem.innerHTML = `
        <input type="text" class="form-control mb-2" name="product-name" placeholder="Nama Produk" required>
        <input type="number" class="form-control mb-2" name="product-quantity" placeholder="Kuantitas" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-danger remove-product">Hapus</button>
        </div>
    `;
    document.getElementById('product-list').appendChild(productItem);
    attachRemoveProductEvent();
});

function attachRemoveProductEvent() {
    document.querySelectorAll('.remove-product').forEach(button => {
        button.removeEventListener('click', removeProduct); // Remove the previous event listener to avoid duplication
        button.addEventListener('click', removeProduct);
    });
}

function removeProduct(event) {
    const productItem = event.target.closest('.product-item');
    productItem.remove();
}

// Attach the remove event to initial products
attachRemoveProductEvent();
