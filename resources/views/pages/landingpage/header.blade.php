 <!-- ***** Preloader Start ***** -->
 <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8">
          <ul class="info">
            <li><i class="fa fa-envelope"></i> kos27@gmail.com</li>
            <li><i class="fa fa-map"></i>Kos Putri 27, Coblong Bandung</li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-4">
          <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
            <li><a href="https://x.com/minthu" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <h1>KOS27</h1>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li><a href="{{ route('guest') }}" class="active">Home</a></li>
                      <li><a href="{{ route('kostan') }}" >Kamar Kos</a></li>
                      <li><a href="{{ route('contact') }}">Kontak</a></li>
                      @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                      @endguest
                      @auth
                        <li>
                          
                          {{-- <li> --}}
                              {{-- <button type="submit" class="dropdown-item d-flex align-items-center"> --}}
                                  {{-- <i class="bi bi-box-arrow-right"></i> --}}
                                  <a >
                                    <form action="{{ route('logout') }}" method="POST">
                                      @csrf
                                      <button style=" background: transparent;border: none;">Logout</button>
                                    </form>  

                                  </a>
                              {{-- </button> --}}
                          {{-- </li> --}}
                        </li>  
                      @endauth
                      {{-- <li><a href="{{ route('booking') }}"><i class="fa fa-calendar"></i> Booking</a></li> --}}
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
