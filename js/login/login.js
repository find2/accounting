function login(){
	var jur = $("#jur").val();
    jur = jur.trim();
	var gel = $("#gel").val();
    gel = gel.trim();
	var tahun = $("#tahun").val();
    tahun = tahun.trim();
	var pr = $("#pr").val();
    pr = pr.trim();
	if (jur == "") {
        alert("Jurusan is required!");
    }
	else if(gel==""){
		alert("Gelombang is required")
	}
	else if(tahun==""){
		alert("Tahun Akademik is required")
	}
    else {
        // Update the details by requesting to the server using ajax
        $.post("../ajax/admin1/read.php", {
			jur:jur,
			gel:gel,
			tahun:tahun,
			pr
            },
            function (data, status) {
                $(".records_content").html(data);
            }
        );
		$("#show_modal").modal("hide");
    }
	
}




