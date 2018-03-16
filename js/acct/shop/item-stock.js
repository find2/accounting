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
	var id_master = $("#id_master").val();
	var qty = $("#qty").val();
	var buy = $("#buy").val().trim();
	var sell = $("#sell").val().trim();
	var id_supplier = $("#id_supplier").val();
    var stock_name = $("#stock_name").val().trim();
    	
    if (id_master == "" || qty == "" || buy == "" || sell == "" || id_supplier == "" || stock_name == "") {
        alert("Please Fill All Available Field!");
    }
    else {
        // Add record
        $.post("../../ajax/acct/shop/item-stock/create.php", {
            id_master:id_master,
            qty:qty,
            buy:buy,
            sell:sell,
            id_supplier:id_supplier,
            name:stock_name            
            
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
		
            // read records again
            readRecords();
 
            // clear fields from the popup
            $("#id_master").val("");
            $("#qty").val("");
            $("#buy").val("");
            $("#sell").val("");
            $("#id_supplier").val("");
            $("#stock_name").val("");
        });
    }
}
// READ records
function readRecords() {
    $.post("../../ajax/acct/shop/item-stock/read.php", {
        
    }, function (data, status) {
        $(".main_content").html(data);
        search_table();
    });

    $("#search_modal").modal("hide");
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
    $.post("../../ajax/acct/shop/item-stock/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var item = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#u_id_master").val(item.id_master);
            $("#u_qty").val(item.qty);
            $("#u_buy").val(item.buy);
            $("#u_sell").val(item.sell);
            $("#u_id_supplier").val(item.id_supplier);
            $("#u_stock_name").val(item.name);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
	var id_master = $("#u_id_master").val();
	var qty = $("#u_qty").val();
	var buy = $("#u_buy").val().trim();
	var sell = $("#u_sell").val().trim();
	var id_supplier = $("#u_id_supplier").val();
    var stock_name = $("#u_stock_name").val().trim();
 
    if (id_master == "" || qty == "" || buy == "" || sell == "" || id_supplier == "" || stock_name == "") {
        alert("Please Fill All Available Field!");
    }
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../../ajax/acct/shop/item-stock/update.php", {
                id:id,
                id_master:id_master,
                qty:qty,
                buy:buy,
                sell:sell,
                id_supplier:id_supplier,
                name:stock_name            
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
        $.post("../../ajax/acct/shop/item-stock/delete.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function readItemMaster(){
    $.post("../../ajax/acct/shop/item-master/list-item-master.php", {
        
    }, function (data, status) {
         $("#id_master").append(data);
         $("#u_id_master").append(data);
    });
}

function readSupplier(){
    $.post("../../ajax/acct/shop/supplier/list-supplier.php", {
        
    }, function (data, status) {
         $("#id_supplier").append(data);
         $("#u_id_supplier").append(data);
    });
}

$(document).ready(function () {
    // READ records on page load
    readRecords(); // calling function
    readItemMaster();
    readSupplier();
});




