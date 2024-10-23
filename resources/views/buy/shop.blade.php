<!-- Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Produk</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-3">
                        <!-- shopSearch start -->
                        @include('buy.shopSearch')
                        <!-- shopSearch end -->
                    </div>
                    <div class="col-xl-6"></div>
                    <div class="col-xl-3">
                        <!-- Sort start
                        @ include('buy.sort')
                         Sort end -->
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">

                            <!-- Category search start -->
                            @include('buy.category')
                            <!-- Category search end -->

                            <!-- Optional untuk featured products -->
                            <!-- @include('buy.featured') -->

                            <!-- Optional untuk banner -->
                             @include('buy.banner')

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            @include('buy.product')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop End-->
