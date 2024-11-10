<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
      <!-- Sidebar Header-->
      <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="{{asset('admincss/img/profile-kosong.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
          @if(Auth::check())
          <h1 class="h5">{{Auth::user()->name}}</h1>
          <p>{{Auth::user()->email}}</p>
          @endif
        </div>
      </div>
      <!-- Sidebar Navidation Menus--><span class="heading">Utama</span>
      <ul class="list-unstyled">
              <li class="{{set_active('admin/dashboard')}}"><a href="{{url('admin/dashboard')}}"> <i class="icon-home"></i>Beranda </a></li>
              <li class="{{set_active('view_category')}}">
                <a href="{{url('view_category')}}"> <i class="icon-grid"></i>Kategori
                </a>
              </li>

              <li class="{{set_active('view_product')}}"><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Produk </a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                  <li><a href="{{url('add_product')}}">Tambah Produk</a></li>
                  <li><a href="{{url('view_product')}}">Lihat Produk</a></li>
                </ul>
              </li>

      </ul>
    </nav>
