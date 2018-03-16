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
    var name = $("#name").val().trim();
	var phone = $("#phone").val().trim();
	
    if (name == "") {
        alert("name field is required!");
    }
	else if (phone == "") {
        alert("phone Field is required!");
    }
    else {
        // Add record
        $.post("../../ajax/acct/shop/supplier/create.php", {
            name:name,
            phone:phone
            
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
		
            // read records again
            readRecords();
 
            // clear fields from the popup
            $("#name").val("");
            $("#phone").val("");
        });
    }
}
// READ records
function readRecords() {
    $.post("../../ajax/acct/shop/supplier/read.php", {
        
    }, function (data, status) {
        $(".main_content").html(data);
        search_table();
    });

    $("#search_modal").modal("hide");
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../../ajax/acct/shop/supplier/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#u_name").val(user.name);
			$("#u_phone").val(user.phone);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var name = $("#u_name").val().trim();
	var phone = $("#u_phone").val().trim();
 
    if (name == "") {
        alert("name field is required!");
    }
	else if (phone == "") {
        alert("code Field is required!");
    }
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../../ajax/acct/shop/supplier/update.php", {
                id: id,
                name: name,
                phone:phone
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
        $.post("../../ajax/acct/shop/supplier/delete.php", {
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




