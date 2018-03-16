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
	var code = $("#code").val().trim();
	
    if (name == "") {
        alert("name field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
    else {
        // Add record
        $.post("../../ajax/acct/shop/item-master/create.php", {
            name:name,
            code:code
            
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
		
            // read records again
            readRecords();
 
            // clear fields from the popup
            $("#name").val("");
            $("#code").val("");
        });
    }
}
// READ records
function readRecords() {
    $.post("../../ajax/acct/shop/item-master/read.php", {
        
    }, function (data, status) {
        $(".main_content").html(data);
        search_table();
    });

    $("#search_modal").modal("hide");
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../../ajax/acct/shop/item-master/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#u_name").val(user.name);
			$("#u_code").val(user.code);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var name = $("#u_name").val().trim();
	var code = $("#u_code").val().trim();
 
    if (name == "") {
        alert("name field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../../ajax/acct/shop/item-master/update.php", {
                id: id,
                name: name,
                code:code
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
        $.post("../../ajax/acct/shop/item-master/delete.php", {
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




