<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
        }

        h1 {
            color: white;
        }

        label {
            display: inline-block;
            width: 200px;
            font-size: 18px!important;
            color: white!important;
        }

        input[type="text"],
        input[type="number"] {
            width: 300px;
            height: 50px;
        }

        textarea {
            width: 450px;
            height: 80px;
        }

        .input_deg {
            padding: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>

  </head>
  <body>
    <!-- Navbar -->
    @include('admin.navbar')

    <!-- Sidebar start -->
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <!-- Add Product -->
                <h1>Add Product</h1>

                <div class="div_deg">
                    <form id="productForm" action="{{url('upload_product')}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="input_deg">
                            <label>Product Title</label>
                            <input type="text" name="title" required>
                        </div>

                        <div class="input_deg">
                            <label>Description</label>
                            <textarea name="description" required></textarea>
                        </div>

                        <div class="input_deg">
                            <label>Starting Price</label>
                            <input type="number" name="s_price" id="s_price" required>
                        </div>

                        <div class="input_deg">
                            <label>Discount</label>
                            <input type="number" name="disc" id="disc" required>
                        </div>

                        <div class="input_deg">
                            <label>Final Price</label>
                            <input type="number" id="f_price" readonly>
                            <input type="hidden" name="f_price" id="hidden_f_price" required>
                        </div>

                        <div class="input_deg">
                            <label>&nbsp;</label>
                            <div id="error_message" class="error-message"></div>
                        </div>

                        <div class="input_deg">
                            <label>Quantity</label>
                            <input type="number" name="qty" required>
                        </div>

                        <div class="input_deg">
                            <label>Product Category</label>
                            <select name="category" id="category" required>
                                <option value="">Select an option</option>
                                @foreach ($category as $category)
                                    <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input_deg">
                            <label>Product Image</label>
                            <input type="file" name="image" required>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="input_deg">
                            <input class="btn btn-success" type="submit" value="Add Product">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript files-->

    <!-- Script perhitungan diskon -->
    <script>
        function calculateDiscount() {
            var startingPrice = document.getElementById('s_price').value;
            var discount = document.getElementById('disc').value;
            var errorMessage = document.getElementById('error_message');

            if (discount < 50 || discount>100) {
                errorMessage.textContent = "Discount should be at least 50 and max 100.";
                document.getElementById('f_price').value = "";
                document.getElementById('hidden_f_price').value = "";
            } else {
                errorMessage.textContent = "";
                if (startingPrice && discount) {
                    var finalPrice = startingPrice - (startingPrice * discount / 100);
                    document.getElementById('f_price').value = finalPrice;
                    document.getElementById('hidden_f_price').value = finalPrice;
                }
            }
        }

        document.getElementById('s_price').addEventListener('input', calculateDiscount);
        document.getElementById('disc').addEventListener('input', calculateDiscount);

        document.getElementById('productForm').addEventListener('submit', function(event) {
            var fPrice = document.getElementById('f_price').value;
            var category = document.getElementById('category').value;
            var errorMessage = document.getElementById('error_message');

            if (!fPrice) {
                errorMessage.textContent = "Please provide a valid final price.";
                event.preventDefault(); // Prevent form submission
            } else if (category === "") {
                errorMessage.textContent = "Please select a valid category.";
                event.preventDefault(); // Prevent form submission
            }
        });
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
