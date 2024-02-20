$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// console.log(1);
$(document).ready(function() {
    // // Delay the execution of getMenuAccess() by 2 seconds
    // setTimeout(function() {
    //     getMenuAccess();
    // }, 1000); // 2000 milliseconds = 2 seconds
    getMenuAccess();
});

function getMenuAccess() {
    $.ajax({
        url: baseURL + "/getAccessMenu",
        type: "POST",
        data: JSON.stringify({ uid: 2}),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            // Swal.fire({
            //     title: "Loading",
            //     text: "Please wait...",
            //     showConfirmButton: false, // Menyembunyikan tombol OK
            // });
        },
        complete: function () {
            // swal.close();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                // swal("Saved !", response.info, "success").then(function () {
                //     location.reload();
                // });
                // Reset form
                let data = response.data;
                let groupedData = {};
                let allGroupHTML = ""; // Tambahkan variabel di sini untuk menggabungkan semua grup
                // Loop through the data and group items based on "header_menu"
                data.forEach(function (item) {
                    let groupName = item.header_menu;

                    if (!groupedData[groupName]) {
                        groupedData[groupName] = [];
                    }

                    groupedData[groupName].push(item);
                });

                for (var groupName in groupedData) {
                    var groupItems = groupedData[groupName];


                    // var groupHTML = `<ul class="metismenu" id="${groupName}">
                    //   <li class="menu-title">${groupName}</li>`;
                    var groupHTML = '';

                    groupItems.forEach(function (item) {
                        groupHTML += `
                                        <li class="nav-item">
                                            <a class="nav-link collapsed" id="${groupName}" href="${item.url}">
                                            <i class="bi bi-grid"></i>
                                            <span>${item.menu_name}</span>
                                            </a>
                                        </li>
                                    `;
                        });

                        // groupHTML += `
                        //             <li>
                        //                 <a href="${item.url}" class="">
                        //                     <div class="menu-icon">
                        //                         <i class="bi bi-dot"></i>
                        //                     </div>
                        //                     <span class="nav-text">${item.menu_name}</span>
                        //                 </a>
                        //             </li>`;
                        // });

                    // groupHTML += `</ul>`;

                    allGroupHTML += groupHTML; // Gabungkan semua grup
                }

                // Setelah loop selesai, append semua grup ke elemen dengan class "isSidebarMenu"
                $(".isSidebarMenu").html(allGroupHTML);
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function validationSwalFailed(param, isText) {
    // console.log(param);
    if (param == "" || param == null) {
        sweetAlert("Oops...", isText, "warning");

        return 1;
    }
}

function formatRupiah(angka, prefix) {
    // var angka = angka.split(".");
    if(angka){
      angka = String(angka);
      var seeminus = angka.substr(0,1);
      if(seeminus == '-'){
        var minus = '-';
        var angka = angka.substr(1).replace(/[^,\d]/g, '.');
      }else{
        var minus = '';
        
        var angka = angka.replace(/[^,\d]/g, '.');
      }
      var number_string = angka.toString(),
        split = number_string.split("."),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      
      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }
    
      rupiah = split[1] != undefined ? minus+rupiah + "." + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
    }else{
      return '0.00';
    }
    
}
function datetostring2(p1,p2,p3){
	var month   = new Array();
    month[0]    = "Januari";
    month[1]    = "Februari";
    month[2]    = "Maret";
    month[3]    = "April";
    month[4]    = "Mei";
    month[5]    = "Juni";
    month[6]    = "Juli";
    month[7]    = "Agustus";
    month[8]    = "September";
    month[9]    = "Oktober";
    month[10]   = "November";
    month[11]   = "Desember";

	if(p1 != null && p2 != null){
		if(p1 == 'yymmdd'){
			p2   		= p2.toString().replaceAll('-','');
			yyyy 		= p2.substring(0,4);
			mm 			= p2.substring(4,6);
			dd 			= p2.substring(6,8);
		

			var a       = new Date(yyyy+'-'+mm+'-'+''+dd);
			var tgl     = ('0' + a.getDate()).slice(-2);
			var bulan   = month[a.getMonth()]
			var tahun   = a.getFullYear();
			return tgl+' '+bulan+' '+tahun ;
		}
		if(p1 == 'His'){
			p2   		= p2.toString();
			h			= p2.substring(0,2);
			i			= p2.substring(2,4);
			s			= p2.substring(4,6);
			return h+':'+i+':'+s ;
		}
		if(p1 == 'yymmdd His'){
			p2   		= p2.toString();
			p3			= p3.toString();
			yyyy 		= p2.substring(0,4);
			mm 			= p2.substring(4,6);
			dd 			= p2.substring(6,8);
			h			= p3.substring(0,2);
			i			= p3.substring(2,4);
			s			= p3.substring(4,6);
		

			var a       = new Date(yyyy+'-'+mm+'-'+''+dd);
			var tgl     = ('0' + a.getDate()).slice(-2);
			var bulan   = month[a.getMonth()]
			var tahun   = a.getFullYear();
			return tgl+' '+bulan+' '+tahun+' '+h+':'+i+':'+s ;
		}
		if(p1 == 'yymm'){
			var bln     = p2.substring(4,5);
			if(bln == 0){
				bln     = p2.substring(5,6);
			}else{
				bln     = p2.substring(4,6);
			}

			var bulan   = month[parseInt(bln)-1]
			if(bulan == -1){
				bulan = 0;
			}

			var tahun   = p2.substring(0, 4);
			return bulan+' '+tahun ;
		}
		if(p1 == 'yymmdd His nyatu'){
			var a       = new Date(p2.substring(0,19));
			var tgl     = ('0' + a.getDate()).slice(-2);
			var bulan   = month[a.getMonth()]
			var tahun   = a.getFullYear();
			var h       = String(a.getHours()).padStart(2, '0');
			var m       = String(a.getMinutes()).padStart(2, '0');
			var s		= String(a.getSeconds()).padStart(2, '0');
			return tgl+' '+bulan+' '+tahun+' '+h+':'+m+':'+s ;
		}
    if(p1 == 'mm'){
      var bulan   = month[parseInt(p2)-1]
			if(bulan == -1){
				bulan = 0;
			}
      return bulan
    }
		
	}else{
		return '';
	}
}
function pembilang(nilai) {
  nilai = Math.floor(Math.abs(nilai));
 
  var simpanNilaiBagi = 0;
  var huruf = [
    '',
    'Satu',
    'Dua',
    'Tiga',
    'Empat',
    'Lima',
    'Enam',
    'Tujuh',
    'Delapan',
    'Sembilan',
    'Sepuluh',
    'Sebelas',
  ];
  var temp = '';
 
  if (nilai < 12) {
    temp = ' ' + huruf[nilai];
  } else if (nilai < 20) {
    temp = pembilang(Math.floor(nilai - 10)) + ' Belas';
  } else if (nilai < 100) {
    simpanNilaiBagi = Math.floor(nilai / 10);
    temp = pembilang(simpanNilaiBagi) + ' Puluh' + pembilang(nilai % 10);
  } else if (nilai < 200) {
    temp = ' Seratus' + pembilang(nilai - 100);
  } else if (nilai < 1000) {
    simpanNilaiBagi = Math.floor(nilai / 100);
    temp = pembilang(simpanNilaiBagi) + ' Ratus' + pembilang(nilai % 100);
  } else if (nilai < 2000) {
    temp = ' Seribu' + pembilang(nilai - 1000);
  } else if (nilai < 1000000) {
    simpanNilaiBagi = Math.floor(nilai / 1000);
    temp = pembilang(simpanNilaiBagi) + ' Ribu' + pembilang(nilai % 1000);
  } else if (nilai < 1000000000) {
    simpanNilaiBagi = Math.floor(nilai / 1000000);
    temp = pembilang(simpanNilaiBagi) + ' Juta' + pembilang(nilai % 1000000);
  } else if (nilai < 1000000000000) {
    simpanNilaiBagi = Math.floor(nilai / 1000000000);
    temp =
      pembilang(simpanNilaiBagi) + ' Miliar' + pembilang(nilai % 1000000000);
  } else if (nilai < 1000000000000000) {
    simpanNilaiBagi = Math.floor(nilai / 1000000000000);
    temp = pembilang(nilai / 1000000000000) + ' Triliun' + pembilang(nilai % 1000000000000);
  }
 
  return temp;
}
function swalsuccess(text){
	swal({
		icon    : "warning",
		title   : 'Berhasil',
		text    : text,
		// timer	: 6000
	});
}
function swalwarning(text){
	swal({
		icon    : "warning",
		title   : 'Oops...',
		text    : text,
		// timer	: 6000
	});
}
function getMonthDifference(startDate, endDate) {
  return (
    endDate.getMonth() -
    startDate.getMonth() +
    12 * (endDate.getFullYear() - startDate.getFullYear())
  );
}
function convertrp(id) {
    value = $("#"+id).val();
    $("#"+id).val(keyuprp(value));
}
function keyuprp(angka, prefix)
{
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split    = number_string.split(','),
        sisa     = split[0].length % 3,
        rupiah     = split[0].substr(0, sisa),
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function closenotif() {
  $("#drpnotif").hide();  
}
function shownotif() {
  $("#drpnotif").show();  
}

if(role == 'bendahara koperasi' || role == 'superadmin'){
  gasnotif();
    let counter = 0 ;
    setInterval(() => {
      jml = counter++ 
      if(jml == 300){
        counter = 0 ;
            gasnotif();
    }
  }, 1000);
}
    
function gasnotif(){
  closenotif();
    $("#notifpinjaman").empty();
    $("#notifsimpanan").empty();
    $.ajax({
      url: baseURL + "/getnotif",
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      beforeSend: function () {
          // Swal.fire({
          //     title: "Loading",
          //     text: "Please wait...",
          //     showConfirmButton: false, // Menyembunyikan tombol OK
          // });
      },
      complete: function (response) {
        
      },
      success: function (response) {
          
        pinjaman = response.data[0].pinjaman;
        simpanan = response.data[0].simpanan;

        if(pinjaman >= 1 || simpanan >= 1){
          shownotif();
        }

        if(pinjaman >= 1){
          $("#notifpinjaman").html(pinjaman+" Pengajuan Pinjaman perlu tindakan");
        }

        if(simpanan >= 1){
          $("#notifsimpanan").html(simpanan+" Pengajuan Simpanan perlu tindakan");
        }
      }
    })
}


function datenow(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

function datesimpanan(p,p1){
  if(p){
    var date = moment(p, "YYYY-MM-DD").add(p1, 'months');
    var mm2     = date.format('MM');
    var yyyy2   = date.format('YYYY');
    var perisel = window.datetostring2('yymmdd',yyyy2+""+mm2+"01");
    
    return perisel;
  }else{
    return ''
  }
}
function datesimpananptgj(p,p1){
  if(p){
    var d = moment(p,"YYYY-MM-DD").add(p1, 'months').calendar() ;
    var dt= new Date(d) ;
    var y = dt.getFullYear() ;
    var m = ("0" + (dt.getMonth() + 1)).slice(-2) ;
    var d = ("0" + dt.getDate()).slice(-2) ;
    return window.datetostring2('yymmdd',y+"-"+m+"-"+d)
  }else{
    return ''
  }
}
filteryears()
function filteryears(){
  content = '<option value="">Semua Tahun</option>';
  for(a = 0 ; a < 5 ; a++){
    date = new Date();
    yyyy2= date.getFullYear() - a ;

    content     += "<option value="+yyyy2+">"+yyyy2+"</option>";
  }
  $("#filter-tahun").append(content);
}
filtermonth();
function filtermonth(){
  content = '<option value="">Semua Bulan</option>';
  for(a = 1 ; a < 13 ; a++){
    var mm2     = a ;
    var perisel = window.datetostring2('mm',+mm2);
    content     += "<option value="+mm2+">"+perisel+"</option>";
  }
  $("#filter-bulan").append(content);
}

