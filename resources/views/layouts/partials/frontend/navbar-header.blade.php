  <div class="header-nav animate-dropdown">
      <div class="container">
          <div class="yamm navbar navbar-default" role="navigation">
              <div class="navbar-header">
                  <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed"
                      type="button">
                      <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                          class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              <div class="nav-bg-class">
                  <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                      <div class="nav-outer">
                          <ul class="nav navbar-nav">
                              <li class="active dropdown"> <a href="home.html">Home</a> </li>

                              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-hover="dropdown"
                                      data-toggle="dropdown">Semua Bunga </a>
                                  <ul class="dropdown-menu pages">
                                      <li>
                                          <div class="yamm-content">
                                              <div class="row">
                                                  <div class="col-xs-12 col-menu">
                                                      <ul class="links">
                                                          @foreach ($products as $product)
                                                              <li><a href="#">{{ $product->nama_produk}}</a></li>
                                                          @endforeach
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                  </ul>
                              </li>
                              <li class="dropdown  navbar-right special-menu"> <a href="#">Get 30% off on
                                      selected items</a> </li>
                          </ul>
                          <!-- /.navbar-nav -->
                          <div class="clearfix"></div>
                      </div>
                      <!-- /.nav-outer -->
                  </div>
                  <!-- /.navbar-collapse -->

              </div>
              <!-- /.nav-bg-class -->
          </div>
          <!-- /.navbar-default -->
      </div>
      <!-- /.container-class -->

  </div>
  <!-- /.header-nav -->
  <!-- ============================================== NAVBAR : END ============================================== -->
