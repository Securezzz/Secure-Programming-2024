<h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>


        <section class="no-padding-bottom">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="block">
                  <div class="title"><strong>Category List</strong></div>
                  <table>
                    @foreach ($data as $categories)
                    <tr>
                        <td>{{$categories->category_name}}</td>
                    </tr>
                    @endforeach
                  </table>
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="block">
                      <div class="title"><strong>Product List</strong></div>
                      <table>
                        @foreach ($product as $products)
                        <tr>
                            <td>{{$products->title}}</td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
              </div>

            </div>
          </div>
        </section>


