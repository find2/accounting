var ledger = $("#hidden_ledger").val();

function search_table(){
	$('#myTable tfoot th').each( function () {
		var title = $(this).text();
		$(this).html( '<input item="text" placeholder="Search '+title+'" />' );
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
	var item = $("#item").val().trim();
	var code = $("#code").val().trim();
	var type = $("#type").val().trim();
	var balance = $("#balance").val().trim();
	var year = $("#show_year").val();
	var month = $("#show_month").val();
	
    if (balance == "") {
        alert("Balance Field is required!");
    }
	else if (code == "") {
        alert("Code Field is required!");
    }
	else if (item == "") {
        alert("Item Field is required!");
    }
    else {
        // Add record
        $.post("../ajax/acct/adj/create.php", {
			item:item,
			code:code,
			type:type,
			balance:balance,
			year:year,
            month:month,
            ledger:ledger

        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
		
            // read records again
            readRecords();
 
            // clear fields from the popup
            //$("#date").val("");
			$("#item").val("");
			$("#code").val("");
			$("#balance").val("");
        });
    }
}
// READ records
function readRecords() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var type=1;
    $.post("../ajax/acct/adj/read.php", {
		month:month,
        year:year,
        ledger:ledger
	}, function (data, status) {
        $(".main_content").html(data);
		search_table();
    });
	
	$.post("../ajax/acct/adj/read_code.php", {
		month:month,
		year:year,
        type:type,
        ledger:ledger
	}, function (data, status) {
        $(".add_code_content").html(data);
    });
	
	type=2;
	
	$.post("../ajax/acct/adj/read_code.php", {
		month:month,
		year:year,
        type:type,
        ledger:ledger
	}, function (data, status) {
        $(".update_code_content").html(data);
    });
	
	$("#search_modal").modal("hide");
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../ajax/acct/adj/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
			var debet="Debet";
			var credit="Credit";
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
			$("#update_item").val(user.item);
			if(user.debet>0){
				$("#update_type").val(debet);
				$("#update_balance").val(user.debet);
			}
			else{
				$("#update_type").val(credit);
				$("#update_balance").val(user.credit);
			}
			$("#update_code").val(user.code);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
	var item = $("#update_item").val().trim();
	var code = $("#update_code").val().trim();
	var balance = $("#update_balance").val().trim();
	var type = $("#update_type").val().trim();
     
    if (balance == "") {
        alert("balance Field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
	else if (item == "") {
        alert("item Field is required!");
    }
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../ajax/acct/adj/update.php", {
                id: id,
				item:item,
				code:code,
				balance:balance,
				type:type
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
        $.post("../ajax/acct/adj/delete.php", {
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
    //readRecords(); // calling function
});




