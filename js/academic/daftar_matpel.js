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
    var kode = $("#kode").val();
    kode = kode.trim();
    var nama = $("#nama").val();
    nama = nama.trim();
 
    if (kode == "") {
        alert("Kode Mata Pelatihan is required!");
    }
    else if (nama == "") {
        alert("Nama Mata Pelatihan  field is required!");
    }
	
    else {
        // Add record
        $.post("../ajax/aca_daftar_matpel/create.php", {
            kode: kode,
            nama: nama,
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
 
            // read records again
            readRecords();
 
            // clear fields from the popup
            $("#kode").val("");
            $("#nama").val("");
        });
    }
}
// READ records
function readRecords() {
    $.get("../ajax/aca_daftar_matpel/read.php", {}, function (data, status) {
        $(".records_content").html(data);
		search_table();
    });
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../ajax/aca_daftar_matpel/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#update_kode").val(user.kode);
            $("#update_nama").val(user.nama);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var kode = $("#update_kode").val();
    kode = kode.trim();
    var nama = $("#update_nama").val();
    nama = nama.trim();
 
    if (kode == "") {
        alert("Kode Mata Pelatihan field is required!");
    }
    else if (nama == "") {
        alert("Nama Mata Pelatihan  field is required!");
    }
	
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../ajax/aca_daftar_matpel/update.php", {
                id: id,
                kode: kode,
                nama: nama
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
        $.post("../ajax/aca_daftar_matpel/delete.php", {
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

document.onkeyup=function(e){
  var e = e || window.event; // for IE to cover IEs window event-object
  if(e.altKey && e.which == 65) {
    //alert('Keyboard shortcut working!');
    $('#add_new_record_modal').modal('show');
	return false;
  }
}



