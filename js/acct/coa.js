var ledger = $("#hidden_ledger").val(); 

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
	var type = $("#type").val().trim();
	var balance = $("#balance").val().trim();
	var year = $("#show_year").val();
    var month = $("#show_month").val();

    if (name == "") {
        alert("name field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
	else if (balance == "") {
        alert("balance Field is required!");
    }
	else if (type == "") {
        alert("type Field is required!");
    }
    else {
        // Add record
        $.post("../ajax/acct/coa/create.php", {
            name:name,
			code:code,
			type:type,
			balance:balance,
			year:year,
            month:month,
            ledger:ledger
            
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
            
            readRecords();
            
            // clear fields from the popup
            $("#name").val("");
			$("#code").val("");
			$("#type").val("");
			$("#balance").val("");
        });
    }
}

// READ records
function readRecords() {
    var month = $("#show_month").val().trim();
    var year = $("#show_year").val().trim();
    $.post("../ajax/acct/coa/read.php", {
        month:month,
        year:year,
        ledger:ledger
    }, function (data, status) {
        $(".main_content").html(data);
        search_table();
        $("#search_modal").modal("hide");
    });
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../ajax/acct/coa/details.php/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#update_name").val(user.name);
			$("#update_code").val(user.code);
			$("#update_type").val(user.type);
			$("#update_balance").val(user.balance);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var name = $("#update_name").val().trim();
	var code = $("#update_code").val().trim();
	var type = $("#update_type").val().trim();
	var balance = $("#update_balance").val().trim();
 
    if (name == "") {
        alert("name field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
	else if (balance == "") {
        alert("balance Field is required!");
    }
	else if (type == "") {
        alert("Type Field is required!");
    }
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../ajax/acct/coa/update.php", {
                id: id,
                name: name,
				code:code,
				type:type,
                balance:balance
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
        $.post("../ajax/acct/coa/delete.php", {
                id: id,
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords(2);
            }
        );
    }
}

function DeleteMonth() {
	var month = $("#show_month").val().trim();
	var year = $("#show_year").val().trim();
    var conf = confirm("Are you sure, do you really want to delete data in this month?");
    if (conf == true) {
        $.post("../ajax/acct/coa/delete_month.php", {
                month:month,
                year:year,
                ledger:ledger
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
    //readRecords(); // calling function
});




