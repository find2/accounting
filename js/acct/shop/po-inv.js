var item_number = 0;
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
    // ambil child dari parent item_content, lalu masing masing child di panggil id nya, jika tidak nemu n++
    var id_supplier = $("#id_supplier").val();
    var title = $("#title").val().trim();
    var n = i = 1;
    var count = $("#item_content").children().length;
	// var id_master = id_item_stock = stock_name = buy = sell = qty = new Array(count);
	var id_master = new Array(count); id_item_stock = new Array(count); stock_name = new Array(count); buy = new Array(count); sell = new Array(count); qty = new Array(count);
    while(i<=count){
        var str = ["#id_master_"+n, "#id_item_stock_"+n, "#name_"+n, "#buy_"+n, "#sell_"+n, "#qty_"+n, "#id_panel_"+n];
        if($(str[0]).val() == null){
            n++;
        }
        else{
            id_master.push($(str[0]).val());
            id_item_stock.push($(str[1]).val());
            stock_name.push($(str[2]).val());
            buy.push($(str[3]).val());
            sell.push($(str[4]).val());
            qty.push($(str[5]).val());
            $(str[6]).remove();
            
            n++;
            i++;
        }
    }
    
    if (id_supplier == "" ) {
        alert("Please Fill All Available Field!");
    }
    else {
        // Add record
        $.post("../../ajax/acct/shop/po-inv/create.php", {
            title:title,
            count:count,
            id_supplier:id_supplier,
            id_master:id_master,
            id_item_stock:id_item_stock,
            name:stock_name,            
            buy:buy,
            sell:sell,
            qty:qty
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
            
            // read records again
            readRecords();
            item_number = 0;
 
            // clear fields from the popup
            $("#id_supplier").val("");
            $("#title").val("");
        });
    }
}
// READ records
function readRecords() {
    var type_data = $("#type_data").val();
    $.post("../../ajax/acct/shop/po-inv/read.php", {
        type_data:type_data
    }, function (data, status) {
        $(".main_content").html(data);
        // search_table();
    });

    $("#search_modal").modal("hide");
}



function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete data?");
    if (conf == true) {
        $.post("../../ajax/acct/shop/po-inv/delete.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function moveToInv(id){
    var conf = confirm("Move Pre-order to Invoice?");
    if (conf == true) {
        $.post("../../ajax/acct/shop/po-inv/move-to-inv.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

// Generate content
function readItemMaster(n){
    var id = "#id_master_"+n;
    $.post("../../ajax/acct/shop/item-master/list-item-master.php", {
        
    }, function (data, status) {
         $(id).append(data);
        //  $("#u_id_master").append(data);
    });
}

function readSupplier(){
    $.post("../../ajax/acct/shop/supplier/list-supplier.php", {
        
    }, function (data, status) {
         $("#id_supplier").append(data);
         $("#u_id_supplier").append(data);
    });
}

function addRadioButtonStock(n){
    var id = "#stock_"+n;
    $.post("../../ajax/acct/shop/po-inv/add-radio-button-stock.php", {
        id:n,
        type:'1'
    }, function (data, status) {
        $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function currentStock(n){
    var id = "#item_stock_"+n;
    var id2 = "#buy_sell_"+n;
    var id_master = "#id_master_"+n;
    id_master = $(id_master).val();
    $.post("../../ajax/acct/shop/po-inv/current-stock.php", {
        id:n,
        id_master:id_master,
        type:'1'
    }, function (data, status) {
        $(id2).html("");
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function newStock(n){
    var id = "#buy_sell_"+n;
    var id2 = "#item_stock_"+n;
    var id_item_stock = 0;
    $.post("../../ajax/acct/shop/po-inv/add-buy-sell.php", {
        id:n,
        id_item_stock:id_item_stock,
        type:'1'
    }, function (data, status) {
        $(id2).html("");
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function addBuySell(n){
    var id = "#buy_sell_"+n;
    var id_item_stock = "#id_item_stock_"+n;
    id_item_stock = $(id_item_stock).val();
    $.post("../../ajax/acct/shop/po-inv/add-buy-sell.php", {
        id:n,
        id_item_stock:id_item_stock,
        type:'1'
    }, function (data, status) {
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function addItem(){
    item_number ++;
    $.post("../../ajax/acct/shop/po-inv/add-item.php", {
        item_number:item_number,
        type:'1'
    }, function (data, status) {
        $("#item_content").append(data);
        readItemMaster(item_number);
        $('.clickable').on('click',function(){
            var effect = $(this).data('effect');
            $(this).closest('.panel')[effect]();
            $(this).html(" ");
        })
    });
}

function u_addItem_new(){
    item_number ++;
    $.post("../../ajax/acct/shop/po-inv/add-item.php", {
        item_number:item_number,
        type:'3'
    }, function (data, status) {
        $("#u_item_content").append(data);
        // readItemMaster(item_number);
        $('.clickable').on('click',function(){
            var effect = $(this).data('effect');
            $(this).closest('.panel')[effect]();
            $(this).html(" ");
        })
    });
}

function removePanel(n){
    var id = "#id_panel_"+n;
    $(id).remove();
}

// ENd Content

// Generate content

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#u_item_content").html("");
    item_number = 0;
    var total_item = 0, po = null;
    $("#hidden_user_id").val(id);

    $.post("../../ajax/acct/shop/po-inv/read-total-po.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            total_item = data;
        }
    );

    $.post("../../ajax/acct/shop/po-inv/details-item-po.php", {
        id: id
    },
    function (data, status) {
            po = JSON.parse(data);
console.log(JSON.parse(data));
        }
    );

    $.post("../../ajax/acct/shop/po-inv/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var item = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#u_id_supplier").val(item.id_supplier);
            $("#u_title").val(item.title);
            // Start Loop
            for(var i=1; i<=total_item; i++){
                //Add Item
                item_number++;                
                u_addItem(i, po[i-1]);
            }
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function set_value(){
}

function UpdateUserDetails() {
    // get values
	var id_supplier = $("#u_id_supplier").val();
    var title = $("#u_title").val().trim();
    var n = i = 1;
    // var count = $("#u_item_content").children().length;
    var count = item_number;
	var id_master = id_item_stock = stock_name = buy = sell = qty = new Array(count);
	var id_master = new Array(count); id_item_stock = new Array(count); stock_name = new Array(count); buy = new Array(count); sell = new Array(count); qty = new Array(count);
    while(i<=count){
        var str = ["#u_id_master_"+n, "#u_id_item_stock_"+n, "#u_name_"+n, "#u_buy_"+n, "#u_sell_"+n, "#u_qty_"+n, "#u_id_panel_"+n];
        if($(str[0]).val() == null){
            n++;
        }
        else{
            id_master.push($(str[0]).val());
            id_item_stock.push($(str[1]).val());
            stock_name.push($(str[2]).val());
            buy.push($(str[3]).val());
            sell.push($(str[4]).val());
            qty.push($(str[5]).val());
            $(str[6]).remove();
            
            n++;
            i++;
        }
    }
    
    if (id_supplier == "" ) {
        alert("Please Fill All Available Field!");
    }
    else {
        var id = $("#hidden_user_id").val();
        // Add record
        $.post("../../ajax/acct/shop/po-inv/update.php", {
            title:title,
            count:count,
            id_supplier:id_supplier,
            id_master:id_master,
            id_item_stock:id_item_stock,
            name:stock_name,            
            buy:buy,
            sell:sell,
            qty:qty,
            id:id
        }, function (data, status) {
            // close the popup
            $("#update_user_modal").modal("hide");
            
            // read records again
            readRecords();
            item_number = 0;
 
            // clear fields from the popup
            $("#u_id_supplier").val("");
            $("#u_title").val("");
        });
    }
}

function u_addItem(i, po){
    $.post("../../ajax/acct/shop/po-inv/add-item.php", {
        item_number:i,
        type:'2',
        id_item_stock:po.id_item_stock,
        id_master:po.id_master,
        qty:po.qty,
        buy:po.buy,
        sell:po.sell,
        name:po.name
    }, function (data, status) {
        $("#u_item_content").append(data);
        // u_readItemMaster(i);
        $('.clickable').on('click',function(){
            var effect = $(this).data('effect');
            $(this).closest('.panel')[effect]();
            $(this).html(" "); 
        })
    });
    
    // $("#u_id_master_"+i).val(po.id_master);
}



function u_readItemMaster(n){
    var id = "#u_id_master_"+n;
    $.post("../../ajax/acct/shop/item-master/list-item-master.php", {
        
    }, function (data, status) {
        // alert(data);
        $(id).append(data);
        //  $("#u_id_master").append(data);
    });
}

function u_addRadioButtonStock(n){
    var id = "#u_stock_"+n;
    $.post("../../ajax/acct/shop/po-inv/add-radio-button-stock.php", {
        id:n,
        type:'2'
    }, function (data, status) {
        $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function u_currentStock(n){
    var id = "#u_item_stock_"+n;
    var id2 = "#u_buy_sell_"+n;
    var id_master = "#u_id_master_"+n;
    id_master = $(id_master).val();
    $.post("../../ajax/acct/shop/po-inv/current-stock.php", {
        id:n,
        id_master:id_master,
        type:'2'
    }, function (data, status) {
        $(id2).html("");
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function u_newStock(n){
    var id = "#u_buy_sell_"+n;
    var id2 = "#u_item_stock_"+n;
    var id_item_stock = 0;
    $.post("../../ajax/acct/shop/po-inv/add-buy-sell.php", {
        id:n,
        id_item_stock:id_item_stock,
        type:'2'
    }, function (data, status) {
        $(id2).html("");
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function u_addBuySell(n){
    var id = "#u_buy_sell_"+n;
    var id_item_stock = "#u_id_item_stock_"+n;
    id_item_stock = $(id_item_stock).val();
    $.post("../../ajax/acct/shop/po-inv/add-buy-sell.php", {
        id:n,
        id_item_stock:id_item_stock,
        type:'2'
    }, function (data, status) {
         $(id).html(data);
        //  $("#u_id_master").append(data);
    });
}

function u_removePanel(n){
    var id = "#u_id_panel_"+n;
    $(id).remove();
}

$(document).ready(function () {
    // READ records on page load
    readSupplier();
    // readItemMaster();
    //readRecords(); // calling function
});




