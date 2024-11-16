<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Spinner and Navbar start -->
    @include('master.navbar')
    <!-- Spinner and Navbar end -->

    <!-- Modal Search Start -->
    @include('home.search')
    <!-- Modal Search End -->

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Keranjang</h1>
    </div>
    <!-- Single Page Header End -->

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $cartItem)
                            @if($cartItem->product)
                                <tr data-item-id="{{ $cartItem->id }}">
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="/products/{{ $cartItem->product->image }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $cartItem->product->title }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 final-price" data-price="{{ $cartItem->product->final_price }}">{{ $cartItem->product->final_price }}</p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <div class="input-group-btn dec">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-center border-0 quantity-input" value="{{ $cartItem->quantity }}" data-max-quantity="{{ $cartItem->product->quantity }}" data-item-id="{{ $cartItem->id }}" readonly>
                                            <div class="input-group-btn inc">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total-price"></p>
                                    </td>
                                    <td>
                                        <a class="btn btn-md rounded-circle bg-light border mt-4" href="{{url('deleteCart', $cartItem->id )}}">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="cart_value" style="text-align: center">
        <h3>Total Harga: <span id="grand-total">0.00</span></h3>
        <button type="submit" class="btn btn-success btn-block" id="confirmPayment">
            Bayar
        </button>
    </div>

    <!-- QRIS Modal -->
    <div class="modal fade" id="qrisModal" tabindex="-1" aria-labelledby="qrisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrisModalLabel">Selesaikan Pembayaran Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>Scan QR code di bawah untuk menyelesaikan transaksi:</p>
                    <img src="../img/qrcode.png" alt="QRIS Code" class="img-fluid" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Urungkan</button>
                    <button type="button" class="btn btn-success" id="confirmPaymentModal">Pembayaran Berhasil</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    @include('./master.footer')
    <!-- Footer End -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle "Bayar" button click
            document.getElementById('confirmPayment').addEventListener('click', function() {
                const cartItems = [];
                document.querySelectorAll('tbody tr').forEach(row => {
                    cartItems.push({
                        id: row.getAttribute('data-item-id'),
                        quantity: parseInt(row.querySelector('.quantity-input').value)
                    });
                });

                // Kirim permintaan AJAX untuk validasi
                $.ajax({
                    url: '/validate-payment',
                    type: 'POST',
                    data: {
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        cart_items: cartItems,
                        calculated_total: parseFloat(document.getElementById('grand-total').innerText)
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#qrisModal').modal('show');
                            // Proses pembayaran selanjutnya
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });


            // Handle "Pembayaran Berhasil" button click in modal
            document.getElementById('confirmPaymentModal').addEventListener('click', function() {
                // Make an AJAX request to delete all cart items
                $.ajax({
                    url: '/clearCart',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#qrisModal').modal('hide');

                            // Show success notification
                            alert('Pembayaran berhasil!');

                            // Clear the cart table
                            document.querySelector('tbody').innerHTML = '';
                            document.getElementById('grand-total').innerText = '0.00';
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            document.querySelector('tbody').addEventListener('click', function(event) {
                if (event.target.closest('.btn-plus')) {
                    incrementQuantity(event.target.closest('.btn-plus'));
                } else if (event.target.closest('.btn-minus')) {
                    decrementQuantity(event.target.closest('.btn-minus'));
                }
            });

            function incrementQuantity(button) {
            let input = button.closest('.quantity').querySelector('.quantity-input');
            let currentValue = parseInt(input.value);
            let maxQuantity = parseInt(input.getAttribute('data-max-quantity'));

            if (currentValue <= maxQuantity) {
                input.value = currentValue;
                updateCartQuantity(input.dataset.itemId, input.value);
            } else {
                input.value = currentValue - 1;
                alert("Quantity cannot exceed the available stock.");
            }
        }

        function decrementQuantity(button) {
            let input = button.closest('.quantity').querySelector('.quantity-input');
            let currentValue = parseInt(input.value);

            if (currentValue >= 1) {
                input.value = currentValue;
                updateCartQuantity(input.dataset.itemId, input.value);
            } else {
                input.value = currentValue + 1;
                alert("Quantity cannot be less than 1.");
            }
        }

            function updateTotalPrice() {
                let rows = document.querySelectorAll('tbody tr');
                let grandTotal = 0;

                rows.forEach(row => {
                    let quantity = parseInt(row.querySelector('.quantity-input').value);
                    let finalPrice = parseFloat(row.querySelector('.final-price').getAttribute('data-price'));
                    let totalPrice = quantity * finalPrice;

                    row.querySelector('.total-price').innerText = totalPrice.toFixed(2);
                    grandTotal += totalPrice;
                });

                document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
            }

            function updateCartQuantity(cartItemId, quantity) {
                $.ajax({
                    url: '/updateCartQuantity',
                    type: 'POST',
                    data: {
                        cartItemId: cartItemId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.message);
                            updateTotalPrice();
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Initial calculation
            updateTotalPrice();
        });
    </script>
</body>

</html>
