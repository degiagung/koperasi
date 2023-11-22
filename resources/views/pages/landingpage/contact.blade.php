
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <span class="breadcrumb"><a href="#">Home</a>  /  Contact Us</span>
        <h3>Contact Us</h3>
      </div>
    </div>
  </div>
</div>

<div class="contact-page section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        
        <div class="row">
          <div class="col-lg-4 offset-lg-2">
            <div class="item phone">
              <img src="../ref_layouts/landingpage/assets/images/phone-icon.png" alt="" style="max-width: 52px;">
              <h6>08969873648<br><span>Handphone / WA</span></h6>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="item email">
              <img src="../ref_layouts/landingpage/assets/images/email-icon.png" alt="" style="max-width: 52px;">
              <h6>kos27@gmail.com<br><span>Email</span></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12" style="text-align:center;">
          <h3>Jl. Sekeloa Tengah no.27, Coblong, <br>Kota Bandung, Jawa Barat.</h3>
      </div>
    </div>
  </div>
</div>

{{-- @push('before-script') 
  <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
@endpush --}}

{{-- @push('after-script') 
  <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
  <script>
    setTimeout(() => {
      showmpas()
    }, 2000);
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
        }).setView(latlng, 15);
  
        L.marker(latlng,{icon : myIcon}).addTo(map)
    } 
  </script>
@endpush --}}
