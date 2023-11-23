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
            console.log(response);
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
                    var groupHTML = `<ul class="metismenu" id="${groupName}">
                      <li class="menu-title">${groupName}</li>`;

                    groupItems.forEach(function (item) {
                                          groupHTML += `<li><a href="${item.url}" class="">
                          <div class="menu-icon">
                            <i class="bi bi-dot"></i>
                          </div>
                          <span class="nav-text">${item.menu_name}</span>
                      </a>
                      </li>`;
                    });

                    groupHTML += `</ul>`;

                    allGroupHTML += groupHTML; // Gabungkan semua grup
                }

                // Setelah loop selesai, append semua grup ke elemen dengan class "isSidebarMenu"
                $(".isSidebarMenu").html(allGroupHTML);
            } else {
                sweetAlert("Oops...", response.info, "error");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
            sweetAlert("Oops...", xhr.responseText, "error");
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