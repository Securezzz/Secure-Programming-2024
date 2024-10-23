<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')

    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
            flex-direction: column;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table_deg {
            border: 2px solid black;
            width: 100%;
            max-width: 100%;
            table-layout: auto;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: white;
            color: black;
            font-size: 19px;
            font-weight: bold;
            border: 2px solid black;
        }

        td {
            border: 1px solid black;
            color: white;
            word-wrap: break-word;
        }

        .image-container {
            width: 120px;
            height: 120px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Search */
        input[type="search"] {
            width: 100%;
            max-width: 500px;
            height: 40px;
            margin-bottom: 20px;
        }

        /* Pagination Margin */
        .pagination {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    @include('admin.navbar')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <form action="{{url('product_search')}}" method="get">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="search" name="search" class="form-control" placeholder="Cari produk atau kategori">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>

                <div class="div_deg">
                    <div class="table-responsive">
                        <table class="table_deg table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga Awal</th>
                                    <th>Diskon</th>
                                    <th>Harga Akhir</th>
                                    <th>Gambar</th>
                                    <th>Hapus</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $products)
                                <tr>
                                    <td>{{$products->title}}</td>
                                    <td>{{$products->description}}</td>
                                    <td>{{$products->category}}</td>
                                    <td>{{$products->quantity}}</td>
                                    <td>{{$products->starting_price}}</td>
                                    <td>{{$products->discount}}</td>
                                    <td>{{$products->final_price}}</td>
                                    <td>
                                        <div class="image-container">
                                            <img src="products/{{$products->image}}" alt="Product Image">
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_product', $products->id)}}">Hapus</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{url('edit_product', $products->id)}}">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        {{$product->onEachSide(1)->links()}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript files-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            swal({
                title: "Are you sure to delete this?",
                text: "This delete will be permanent",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willCancel) => {
                if (willCancel) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>
</html>

@include('admin.footer')
