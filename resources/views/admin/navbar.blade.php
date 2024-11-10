<header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="search-panel">
        <div class="search-inner d-flex align-items-center justify-content-center">
          <div class="close-btn">Close <i class="fa fa-close"></i></div>
          <form id="searchForm" action="#">
            <div class="form-group">
              <input type="search" name="search" placeholder="What are you searching for...">
              <button type="submit" class="submit">Search</button>
            </div>
          </form>
        </div>
      </div>
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <div class="navbar-header">
          <!-- Navbar Header--><a href="index.html" class="navbar-brand">
            <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">EcoSavor</strong><strong>Admin</strong></div>
            <div class="brand-text brand-sm"><strong class="text-primary">E</strong><strong>A</strong></div></a>
          <!-- Sidebar Toggle Btn-->
          <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
        </div>

          <!-- Log out               -->
          <ul class="nav nav-pillslogout">
            <a type="button" class="nav-item btn btn-light mr-1 text-dark" href="{{ route('/')}}">Go to user page</a>
            <form method="POST" action="{{ route('logout') }}" class="nav-item">
                @csrf
                <input type="submit" value="Logout" type="button" class="btn btn-danger">
            </form>
        </ul>
      </div>
    </nav>
  </header>
