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
    var date = $("#add_date").val();
	var trx = $("#trx").val().trim();
	var item = $("#item").val().trim();
	var code = $("#code").val().trim();
	var type = $("#type").val().trim();
	var balance = $("#balance").val().trim();
	var year = $("#show_year").val();
	var month = $("#show_month").val();
	var remark = $("#remark").val().trim();
	var bank_name = $("#bank_name").val();
	
    if (date == "") {
        alert("date field is required!");
    }
	else if (balance == "") {
        alert("trx Field is required!");
    }
	else if (code == "") {
        alert("code Field is required!");
    }
	else if (item == "") {
        alert("item Field is required!");
    }
    else {
        // Add record
        $.post("../ajax/acct/bank/create.php", {
            date:date,
			trx:trx,
			item:item,
			code:code,
			type:type,
			balance:balance,
			year:year,
			month:month,
			remark:remark,
			bank_name:bank_name,
			ledger:ledger
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
		
            // read records again
            readRecords();
 
            // clear fields from the popup
            //$("#date").val("");
			$("#trx").val("");
			$("#item").val("");
			$("#code").val("");
			$("#balance").val("");
        });
    }
}
// READ records
function select_type(n){
	if(n==1){
		var code = $("#code").val();
		var type = "#type";
	}
	else{
		var code = $("#update_code").val();
		var type = "#update_type";
	}
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	if(code != ""){
		$.post("../ajax/acct/cash/select_type.php", {
				code: code,
				month:month,
				year:year
			},
			function (data, status) {
				// reload Users by using readRecords();
				$(type).val(data);
			}
		);
	}
}

function readRecords() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var filter = $("#filter").val();
	var bank_name = $("#bank_name").val();
	var type=1;
	
	if (month == "" || year== "" || bank_name=="") {
		alert("Please select all required fields!");
    }
    else{
		$("#add_button").removeAttr("disabled");
		$.post("../ajax/acct/bank/read.php", {
		month:month,
		year:year,
		filter:filter,
		bank_name:bank_name,
		ledger:ledger
		}, function (data, status) {
			$(".main_content").html(data);
			search_table();
		});

		$.post("../ajax/acct/cash/read_code.php", {
			month:month,
			year:year,
			type:type,
			ledger:ledger
		}, function (data, status) {
			$(".add_code_content").html(data);
		});

		type=2;

		$.post("../ajax/acct/cash/read_code.php", {
			month:month,
			year:year,
			type:type,
			ledger:ledger
		}, function (data, status) {
			$(".update_code_content").html(data);
		});
	} 
    
	$("#search_modal").modal("hide");
}

function show_bank() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
    $.post("../ajax/acct/bank/read_bank.php", {
		month:month,
		year:year,
		ledger:ledger
	}, function (data, status) {
        $(".bank_content").html(data);
    });
	
}


function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../ajax/acct/bank/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
			var debet="Debet";
			var credit="Credit";
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#update_date").val(user.date);
            $("#update_date_hidden").val(user.date);
			$("#update_trx").val(user.trx);
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
			$("#update_remark").val(user.remark);
			
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var date = $("#update_date").val().trim();
	var trx = $("#update_trx").val().trim();
	var item = $("#update_item").val().trim();
	var code = $("#update_code").val().trim();
	var balance = $("#update_balance").val().trim();
	var type = $("#update_type").val().trim();
	var remark = $("#update_remark").val().trim();
 
    if (date == "") {
        alert("date field is required!");
    }
	else if (balance == "") {
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
        $.post("../ajax/acct/bank/update.php", {
                id: id,
                date: date,
				trx:trx,
				item:item,
				code:code,
				balance:balance,
				type:type,
				remark:remark,
				ledger:ledger
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
        $.post("../ajax/acct/bank/delete.php", {
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
	// show_bank();
    // READ records on page load
    //readRecords(); // calling function
	$("#add_button").attr("disabled", "true");
});

function pdf_all() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var filter = $("#filter").val();
	var bank_name = $("#bank_name").val();
	url="../ajax/acct/bank/pdf_all.php?month="+month+"&year="+year+"&filter="+filter+"&bank_name="+bank_name+"&ledger="+ledger;
	if(month=="" && year==""){
		alert("Please show data");
	}
	else{
		var win = window.open(url, '_blank');
		win.focus();		
	}
}




