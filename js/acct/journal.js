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

// READ records
function readRecords() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var filter = $("#filter").val();
	var name = $("#name").val().trim();
	var type = $("#type").val();
	
	if (month == "" && year== "" && name=="") {
        alert("Please select all required fields!");
    }
    else{
		$.post("../ajax/acct/journal/read.php", {
		month:month,
		year:year,
		filter:filter,
		name:name,
		type:type,
		ledger:ledger
		}, function (data, status) {
			$(".main_content").html(data);
			search_table();
		});
	} 
    
	$("#search_modal").modal("hide");
}

function show_bank() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
    $.post("../ajax/acct/journal/read_bank.php", {
		month:month,
		year:year,
		ledger:ledger
	}, function (data, status) {
        $(".bank_content").html(data);
    });
	
}




$(document).ready(function () {
    // READ records on page load
    //readRecords(); // calling function
});




