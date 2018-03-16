var ids=[];
var ids2=[]; var ids2_str="";
var ids3=[];

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

function search_table2(){
	$('#myTable2 tfoot th').each( function () {
		var title2 = $(this).text();
		$(this).html( '<input type="text" placeholder="Search '+title2+'" />' );
	} );
 
	// DataTable
	var table2 = $('#myTable2').DataTable();
 
	// Apply the search
	table2.columns().every( function () {
		var that2 = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that2.search() !== this.value ) {
				that2
					.search( this.value )
					.draw();
			}
		} );
	} );
}

function search_table3(){
	$('#myTable3 tfoot th').each( function () {
		var title3 = $(this).text();
		$(this).html( '<input type="text" placeholder="Search '+title3+'" />' );
	} );
 
	// DataTable
	var table3 = $('#myTable3').DataTable();
 
	// Apply the search
	table3.columns().every( function () {
		var that3 = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that3.search() !== this.value ) {
				that3
					.search( this.value )
					.draw();
			}
		} );
	} );
}

function search_table4(){
	$('#myTable4 tfoot th').each( function () {
		var title4 = $(this).text();
		$(this).html( '<input type="text" placeholder="Search '+title4+'" />' );
	} );
 
	// DataTable
	var table4 = $('#myTable4').DataTable();
 
	// Apply the search
	table4.columns().every( function () {
		var that4 = this;
 
		$( 'input', this.footer() ).on( 'keyup change', function () {
			if ( that4.search() !== this.value ) {
				that4
					.search( this.value )
					.draw();
			}
		} );
	} );
}

// Add Record
function addRecord() {
    // get values
    var tahun_aka = $("#tahun_aka").val();
    tahun_aka = tahun_aka.trim();
    var per = $("#per").val();
    per = per.trim();
    var jur = $("#jur").val();
    jur = jur.trim();
    var sem = $("#sem").val();
    sem = sem.trim();
    var nama = $("#nama").val();
    nama = nama.trim();
    var ajaran = $("#ajaran").val();
    ajaran = ajaran.trim();
	var siswa="";
	for(var i=0;i<ids.length;i++){
		siswa+=ids[i]+" ";
	}
	siswa=siswa.trim();
 
    if (tahun_aka == "") {
        alert("Tahun Akademik is required!");
    }
    else if (nama == "") {
        alert("Nama Kelas  field is required!");
    }
	
    else {
        // Add record
        $.post("../ajax/aca_nilai_uts/create.php", {
            tahun_aka: tahun_aka,
            nama: nama,
			jur:jur,
			per:per,
			sem:sem,
			ajaran:ajaran,
			siswa:siswa
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");
 
            // read records again
            //readRecords2(nama);
			location.reload();
            // clear fields from the popup
            $("#tahun_aka").val("");
            $("#nama").val("");
            $("#per").val("");
            $("#jur").val("");
            $("#sem").val("");
        });
    }
}
// READ records
function readRecords() {
	var kelas = $("#search_kelas").val();
    kelas = kelas.trim();
	
	$.post("../ajax/aca_nilai_uts/read.php", {
		kelas:kelas
		
	}, function (data, status) {
		$(".records_content").html(data);
		search_table();
		search_table3();
	});		
	$("#search_modal").modal("hide");
}

function read_matpel(id) {
	var num1=$("#hidden_number_matpel").val();
	num1=num1.trim();
	$.post("../ajax/aca_nilai_uts/read_matpel.php", {
		num1:num1,
		id:id
		
	}, function (data, status) {
		$(".read_matpel").html(data);
	});		
}

function GetUserDetails(id) {
    // Add User ID to the hidden field
    $("#hidden_user_id").val(id);
	
    $.post("../ajax/aca_nilai_uts/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#update_tahun_aka").val(user.tahun_aka);
            $("#update_nama").val(user.nama);;
            $("#update_per").val(user.per);
            $("#update_jur").val(user.jur);
            $("#update_sem").val(user.sem);
            $("#update_ajaran").val(user.id_ajaran);
			ids2=user.id_siswa.split(" ");
			var num1=$("#hidden_number").val();
			var i=1;
			var check="update_check";
			for(i=1;i<=num1;i++){
				var check2=check+i.toString();
				for(var l=0;l<ids2.length;l++){
					if(document.getElementById(check2).value == ids2[l] )
						document.getElementById(check2).checked = true;
				}
			}
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function GetUserDetails2(id, id_siswa) {
    // Add User ID to the hidden field
    $("#hidden_id_kelas").val(id);
    $("#hidden_id_siswa").val(id_siswa);
	read_matpel(id);
	var num1=$("#hidden_number_matpel").val();
	
    $.post("../ajax/aca_nilai_uts/details.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assign existing values to the modal popup fields
			ids3=user.id_lecturers.split(" ");
			var check="update_ins";
			var i=1;
			for(i=1;i<num1;i++){alert();
				var check2=check+i.toString();
				var s=document.getElementById(check2);
				s.value=ids3[i-1];
			}
        }
    );
    $("#update_user_modal2").modal("show");
    // Open modal popup
}

function UpdateUserDetails() {
    // get values
    var tahun_aka = $("#update_tahun_aka").val();
    tahun_aka = tahun_aka.trim();
    var nama = $("#update_nama").val();
    nama = nama.trim();
	var jur = $("#update_jur").val();
    jur = jur.trim();
    var sem = $("#update_sem").val();
    sem = sem.trim();
    var per = $("#update_per").val();
    per = per.trim();
	var ajaran = $("#update_ajaran").val();
    ajaran = ajaran.trim();
	var siswa="";
	for(var i=0;i<ids2.length;i++){
		siswa+=ids2[i]+" ";
	}
	siswa=siswa.trim();
	
    if (tahun_aka == "") {
        alert("Tahun Akademik field is required!");
    }
    else if (nama == "") {
        alert("Nama Mata Pelatihan  field is required!");
    }
	
    else {
        // get hidden field value
        var id = $("#hidden_user_id").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../ajax/aca_nilai_uts/update.php", {
                id: id,
                tahun_aka: tahun_aka,
                nama: nama,
				per:per,
				jur:jur,
				sem:sem,
				ajaran:ajaran,
				siswa:siswa
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

function UpdateUserDetails2() {
    // get values
	var num1=$("#hidden_number_matpel").val();
	var nilai="";
	var check="update_nilai";
	var i=1
	for(i=1;i<num1;i++){
		var check2=check+i.toString();
		var s=document.getElementById(check2);
		nilai+=s.value.toString()+" ";
	}
	nilai=nilai.trim();
	
    if (nilai == "") {
        alert("Nilai is required!");
    }
    else {
        // get hidden field value
        var id_kelas = $("#hidden_id_kelas").val();
        var id_siswa = $("#hidden_id_siswa").val();
		id_kelas=id_kelas.trim();
		id_siswa=id_siswa.trim();
        // Update the details by requesting to the server using ajax
        $.post("../ajax/aca_nilai_uts/update_nilai.php", {
                id_kelas: id_kelas,
                id_siswa: id_siswa,
                nilai:nilai
            },
            function (data, status) {
                // hide modal popup
                $("#update_user_modal2").modal("hide");
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete data?");
    if (conf == true) {
        $.post("../ajax/aca_nilai_uts/delete.php", {
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

function check_all(total){
	var i=1;
	var check="check";
	for(i=1;i<total;i++){
		var check2=check+i.toString();
		document.getElementById(check2).checked = false;
	}
	ids.length=0;
}

function murid_checked(id,num){
	var check="#check"+num.toString();
	if($(check).is(":checked")){
		ids.push(id);
	}
	else{
		ids.splice(ids.indexOf(id),1);
	}
	
}

function check_all2(total){
	var i=1;
	var check="update_check";
	for(i=1;i<=total;i++){
		var check2=check+i.toString();
		document.getElementById(check2).checked = false;
	}
	ids2.length=0;
}

function murid_checked2(id,num){
	var check="#update_check"+num.toString();
	if($(check).is(":checked")){
		ids2.push(id);
	}
	else{
		ids2.splice(ids.indexOf(id),1);
	}
}







