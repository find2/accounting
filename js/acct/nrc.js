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
	
	if (month == "" && year== "") {
        alert("Please select all required fields!");
    }
    else{
		if(ledger != 7){
			$.post("../ajax/acct/nrc/read.php", {
			month:month,
			year:year,
			filter:filter,
			ledger:ledger
			}, function (data, status) {
				$(".main_content").html(data);
				//search_table();
			});
		}
		else{
			$.post("../ajax/acct/nrc/read_konsul.php", {
			month:month,
			year:year,
			filter:filter,
			ledger:ledger
			}, function (data, status) {
				$(".main_content").html(data);
				//search_table();
			});
		}
	} 
    
	$("#search_modal").modal("hide");
}


$(document).ready(function () {
    // READ records on page load
    //readRecords(); // calling function
});

function pdf_all() {
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var filter = $("#filter").val();
	url="../ajax/acct/nrc/pdf_all.php?month="+month+"&year="+year+"&filter="+filter+"&ledger="+ledger;
	if(month=="" && year==""){
		alert("Please show data");
	}
	else{
		var win = window.open(url, '_blank');
		win.focus();		
	}
}

function closing_month(){
	var month = $("#show_month").val();
	var year = $("#show_year").val();
	var filter = $("#filter").val();
	
	$.post("../ajax/acct/nrc/closing_month.php", {
	month:month,
	year:year,
	filter:filter,
	ledger:ledger
	}, function (data, status) {
		//$(".main_content").html(data);
		//search_table();
		alert("Data Successfully Closed");
	});
}



