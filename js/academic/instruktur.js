function search_table(){
	$('#myTable tfoot th').each( function () {
		var title = $(this).text();
		$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	} );
 
	// DataTable
	var table = $('#myTable').DataTable();
 
	// Apply the search
	table.columns().every( function () {
		var that = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that.search() !== this.value ) {
				that
					.search( this.value )
					.draw();
			}
		} );
	} );
}

// Add Record
function addRecord() {
    // get values
    var nip = $("#nip").val();
    nip = nip.trim();
    var nama = $("#nama").val();
    nama = nama.trim();
    var kota = $("#kota").val();
    kota = kota.trim();
	var alamat = $("#alamat").val();
	alamat = alamat.trim();
	var telpon = $("#telpon").val();
    telpon = telpon.trim();
	var kawin = $("#kawin").val();
    kawin = kawin.trim();
	var anak = $("#anak").val();
    anak = anak.trim();
	var assesor = $("#assesor").val();
    assesor = assesor.trim();
	var sertifikat = $("#sertifikat").val();
    sertifikat = sertifikat.trim();
    if (nama == "") {
        alert("Nama field is required!");
    }
    else if (kota == "") {
        alert("Kota field is required!");
    }
	else if (alamat == "") {
        alert("Alamat Field is required!");
    }
	else if (telpon == "") {
        alert("Telpon Field is required!");
    }
	
    else {
        // Add record
        $.post("../ajax/aca_instruktur/create.php", {
            nip: nip,
            nama: nama,
            kota: kota,
			alamat:alamat,
			telpon:telpon,
			kawin:kawin,	
			anak:anak,
			assesor:assesor,
			sertifikat:sertifikat
			
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
 
            // read records again
            readRecords();
 
            // clear fields from the popup
            $("#nip").val("");
            $("#nama").val("");
            $("#kota").val("");
			$("#alamat").val("");
			$("#telpon").val("");
			$("#kawin").val("");
			$("#anak").val("");
			$("#assesor").val("");
			$("#sertifikat").val("");
        });
    }
}
// READ records
function readRecords() {
    $.get("../ajax/aca_instruktur/read.php", {}, function (data, status) {
        $(".records_content").html(data);
		search_table();
    });
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../ajax/aca_instruktur/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#update_nip").val(user.nip);
            $("#update_nama").val(user.nama);
            $("#update_kota").val(user.kota);
			$("#update_alamat").val(user.alamat);
			$("#update_telpon").val(user.telpon);
			$("#update_kawin").val(user.kawin);
			$("#update_anak").val(user.anak);
			$("#update_assesor").val(user.assesor);
			$("#update_sertifikat").val(user.sertifikat);
			$("#update_resign").val(user.resign);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var nip = $("#update_nip").val();
    nip = nip.trim();
    var nama = $("#update_nama").val();
    nama = nama.trim();
    var kota = $("#update_kota").val();
    kota = kota.trim();
	var alamat = $("#update_alamat").val();
	alamat = alamat.trim();
	var telpon = $("#update_telpon").val();
    telpon = telpon.trim();
	var kawin = $("#update_kawin").val();
    kawin = kawin.trim();
	var anak = $("#update_anak").val();
    anak = anak.trim();
	var assesor = $("#update_assesor").val();
    assesor = assesor.trim();
	var sertifikat = $("#update_sertifikat").val();
    sertifikat = sertifikat.trim();
	var resign = $("#update_resign").val();
    resign = resign.trim();
 
    if (nama == "") {
        alert("Nama field is required!");
    }
    else if (kota == "") {
        alert("Kota field is required!");
    }
	else if (alamat == "") {
        alert("Alamat is required!");
    }
	else if (telpon == "") {
        alert("Telepon is required!");
    }
	
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../ajax/aca_instruktur/update.php", {
                id: id,
                nip: nip,
                nama: nama,
                kota: kota,
				alamat:alamat,
				telpon:telpon,
				kawin:kawin,	
				anak:anak,
				assesor:assesor,
				sertifikat:sertifikat,
				resign:resign
            },
            function (data, status) {
                // hide modal popup
                $("#update_user_modal").modal("hide");
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete data?");
    if (conf == true) {
        $.post("../ajax/aca_instruktur/delete.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

$(document).ready(function () {
    // READ records on page load
    readRecords(); // calling function
});




