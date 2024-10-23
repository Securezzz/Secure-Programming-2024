<div class="container">
    <div class="row">
        @foreach ($product as $products)
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-4">
            <div class="rounded position-relative fruite-item flex-column d-flex w-100 h-100">
                <div class="fruite-img" style="height: 200px; overflow: hidden;">
                    <img src="products/{{$products->image}}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="">
                </div>
                @php
                    $categoryClass = '';
                    switch ($products->category) {
                        case 'Makanan Berat':
                            $categoryClass = 'bg-category-makanan-berat';
                            break;
                        case 'Minuman':
                            $categoryClass = 'bg-category-minuman';
                            break;
                        case 'Camilan':
                            $categoryClass = 'bg-category-camilan';
                            break;
                        case 'Manis-Manis':
                            $categoryClass = 'bg-category-manis-manis';
                            break;
                        case 'Buah dan Sayur':
                            $categoryClass = 'bg-category-buah-dan-sayur';
                            break;
                        case 'Bahan Makanan':
                            $categoryClass = 'bg-category-bahan-makanan';
                            break;
                        default:
                            $categoryClass = 'bg-secondary'; // Warna default jika kategori tidak dikenali
                    }
                @endphp
                <div class="text-white px-3 py-1 rounded position-absolute {{$categoryClass}}" style="top: 10px; left: 10px;">{{$products->category}}</div>
                <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column flex-grow-1">
                    <h4>{{$products->title}}</h4>
                    <p class="flex-grow-1">{{$products->description}}</p>
                    <div class="d-flex justify-content-between align-items-end mt-auto">
                        <div>
                            @if($products->discount > 0)
                                <p class="text-muted mb-0"><s>Rp{{number_format($products->starting_price, 0, ',', '.')}}</s></p>
                                <p class="text-danger mb-0">Diskon {{$products->discount}}%</p>
                            @endif
                            <p class="text-dark fs-5 fw-bold mb-0">Rp{{number_format($products->final_price, 0, ',', '.')}}</p>
                        </div>
                        <div>
                            <p class="mb-0 text-danger mb-0" style="text-align: center!important">Sisa: {{$products->quantity}}</p>
                            <a href="{{url('add_cart',$products->id)}}" class="btn border border-secondary rounded-pill px-3 text-primary d-flex align-items-center mt-2" style="color: #664C25!important">
                                <i class="fa fa-shopping-bag me-2 text-primary" style="color: #664C25!important"></i> Add to cart
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @endforeach
    </div>
</div>
<div class="pagination d-flex justify-content-center mt-5">
    {{$product->onEachSide(1)->links()}}
</div>

<style>


.pagination
{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
}

.bg-category-makanan-berat {
    background-color: #E56400; /* Warna latar belakang untuk kategori Makanan berat */
}

.bg-category-minuman {
    background-color: #906F3F; /* Warna latar belakang untuk kategori Minuman */
}

.bg-category-camilan {
    background-color: #664C25; /* Warna latar belakang untuk kategori Camilan */
}

.bg-category-manis-manis {
    background-color: #DEC493; /* Warna latar belakang untuk kategori Manis-manis */
}

.bg-category-buah-dan-sayur {
    background-color: #e1e659; /* Warna latar belakang untuk kategori Buah dan sayur */
}

.bg-category-bahan-makanan {
    background-color: #d2691eac; /* Warna latar belakang untuk kategori Bahan makanan */
}
</style>
