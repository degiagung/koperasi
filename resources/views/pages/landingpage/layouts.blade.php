<!DOCTYPE html>
<html lang="en">

  <head>

    <style>
        #map {
            width: '100%';
            height: 400px;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>KOS 27</title>

    <!-- Bootstrap core CSS -->
    <link href="../ref_layouts/landingpage/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/owl.css">
    <link rel="stylesheet" href="../ref_layouts/landingpage/assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />

    @stack('before-js')

<!--

TemplateMo 591 villa agency

https://templatemo.com/tm-591-villa-agency

-->
  </head>

<body>
    @include("pages.landingpage.header")
    @yield('content');
    
    @include('pages.landingpage.contact')
    <div class="col-lg-12">
        <div id="map">
          
        </div>
      </div>
    <footer>
        <div class="container">
            <div class="col-lg-12">
            {{-- <p>
                Jl. Sekeloa Tengah no.27, Coblong, Kota Bandung, Jawa Barat.
            </p> --}}
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="../ref_layouts/landingpage/vendor/jquery/jquery.min.js"></script>
    <script src="../ref_layouts/landingpage/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/isotope.min.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/owl-carousel.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/counter.js"></script>
    <script src="../ref_layouts/landingpage/assets/js/custom.js"></script>
    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
    <script>
        showmpas()
        function showmpas(){
            var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
              '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
              'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
              mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
            grayscale   = L.tileLayer(mbUrl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}),
            streets     = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});
            Google      = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}',  {tileSize: 512, zoomOffset: -1,attribution: 'google'});

            googleSat   = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });
            googleTraffic = L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                minZoom: 2,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            });

            var myIcon = L.icon({
                iconUrl: 'https://img.freepik.com/premium-vector/red-map-pin…l-flat-vector-illustration_136875-3892.jpg?w=2000',
                iconSize: [70, 70],
            });

            latlng = [-6.889600, 107.619940];
            map = L.map('map',{
                layers: [googleSat],
                zoomControl:true, maxZoom:20, minZoom:3, zoomControl: true
            }).setView(latlng, 18);

            L.marker(latlng,{icon : myIcon}).addTo(map)
        } 
    </script>
    @stack('after-script')

</body>
</html>