$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
tipekamar();
listkamar();

function tipekamar(){
    $(".properties-filter").empty();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: baseURL + '/tipeKamar',
        success: function(result){
            let content = '';
            if (result['data']){
                data = result['data'] ;
                content += `
                <li>
                <a class="is_active lifilter" id="liall" href="#!" data-filter="*" onclick="showlist('all')">Tampilkan Semua</a>
                </li>
                `;
                $.each(result.data, function(i,e){
                $id  = e['id']
                $tipe= e['tipe']
                content += `
                    <li>
                        <a class="lifilter" id="li`+$id+`" href="#!" data-filter=".tipe`+$id+`" onclick="showlist(`+$id+`)">`+$tipe+`</a>
                    </li>
                `;
                    
            });
            $(".properties-filter").html(content);
            
            }
        }
    });
}

function listkamar(){
    $(".kostan").empty();
    $.ajax({
    type: 'POST',
    dataType: 'json',
    url: baseURL + '/listkamaravailable',
    success: function(result){
        var content = '<div class="row properties-box" style="height: auto !important">';
        console.log(result)
        $.each(result.data, function(i,e){
            file = baseURL+e['alamat'].replaceAll('../public','')+e['file'];
            id         = e['idkamar'];
            no_kamar   = e['no_kamar'];
            lantai     = e['lantai'];
            harga      = e['harga'];
            tipe       = e['tipe'];
            idtipe     = e['idtipe'];
            fas        = e['faskos'];
            content += `
                <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items col-md-6 tipe`+idtipe+`">
                    <div class="item">
                    <a href="`+baseURL+`/details/`+id+`" }}"><img src="`+file+`" style="width:300px !important;height:300px !important; " alt=""></a>
                    <span class="category" style="font-size:13px">`+tipe+`</span>
                    <h6 style="font-size:13px">Rp . `+formatRupiah(harga)+` / BLN</h6>
                    <h4 style="font-size:18px;">Dilengkapi Fasilitas `+fas+`</h4>
                    <div class="main-button">
                        <a href="`+baseURL+`/details/`+id+`">Booking</a>
                    </div>
                    </div>
                </div>
            `;
                
        });
        content += "</div>";
        $(".kostan").html(content);
    }
    });
}

function showlist(p){
    let elems = document.querySelectorAll(".lifilter");

    [].forEach.call(elems, function(el) {
        el.classList.remove("is_active");
    });


    $(".properties-items").hide();
    if(p == 'all'){
        $(".properties-items").show();
        let li = document.getElementById("liall");
        li.classList.add("is_active");
    }else{
        $(".tipe"+p).show();

        let li = document.getElementById("li"+p);
        li.classList.add("is_active");
    }
}

function formatRupiah(angka, prefix) {
    // var angka = angka.split(".");
	if(angka){
		var seeminus = angka.substr(0,1);
		if(seeminus == '-'){
			var minus = '-';
			var angka = angka.substr(1).replace(/[^,\d]/g, ',');
		}else{
			var minus = '';
			
			var angka = angka.replace(/[^,\d]/g, ',');
		}
		var number_string = angka.toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		
		if (ribuan) {
			separator = sisa ? "," : "";
			rupiah += separator + ribuan.join(",");
		}
	
		rupiah = split[1] != undefined ? minus+rupiah + "." + split[1] : rupiah;
		return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
	}else{
		return '';
	}
    
}