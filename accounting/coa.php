<?php
session_start();
error_reporting(0);

require('lib.php');
$object = new Book();
$ledger = $object->Get_Book($_GET['ledger']);
echo '<input id="hidden_ledger" type="hidden" value='. $_GET["ledger"] .'>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Chart of Account</title>
 
    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
	<!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="../images/icon1.png">
    <!-- Theme CSS -->
    <link href="../css/freelancer.css" rel="stylesheet">
	<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.13/af-2.1.3/b-1.2.4/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.1/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
 
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.10.13/af-2.1.3/b-1.2.4/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.1/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
</head>
<body>
 
  <!-- Content Section -->
<div class="container">
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
				<a class="navbar-brand" href="../home.php" data-toggle="tooltip" data-placement="bottom" title="Back to Home"><img class="profile-img img-responsive img-centered " src="../images/icon_home2.png "
                    alt=""></a>
                <a class="navbar-brand" href="#page-top">Chart of Account <small><?php echo $ledger ?></small></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
					<li class="page-scroll">
						<div class="pull-right">
							<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#search_modal">Show Data</button>
						</div>
					</li>
                    <li class="page-scroll">
						<div class="pull-right">
							<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_new_record_modal">Add Record</button>
						</div>
					</li>
					<li class="page-scroll">
						<div class="pull-right">
							<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#" onclick="DeleteMonth()">Delete Data</button>
						</div>
					</li>
					<li class="page-scroll">
						<div class="pull-right">
							<button type="submit" class="btn btn-success btn-sm" name="logout-btn" onclick="logout()" >Logout</button>
						</div>
					</li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
	</nav>
    <!--<div class="row">
        <div class="col-md-12">
            <h1>Registrasi Basic dan  Middle Level</h1>
        </div>
    </div>-->
	</br></br>
<section>
	<div class="col-md-12">
			<div class="main_content"><h4> Please click <em>"Show Data"</em>  button to show the records</h4>
		</div>
	</div>
</section>
</div>
<!-- Footer -->
<footer class="text-center">
	<div class="footer-below">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					Copyright &copy; Yayasan Widhi Sastra Nugraha - Monarch Bali 2017
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- /Content Section -->
<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->

<!-- SEARCH MODAL -->
<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Show Data</h4>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="show_year">Year:</label>
							<select name="show_year" id="show_year" class="form-control">
								<option value="2017">2017</option>
								<option value="2018" selected>2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="show_month">Month:</label>
							<select name="show_month" id="show_month" class="form-control">
								<option value="January">January</option>
								<option value="February">February</option>
								<option value="March">March</option>
								<option value="April">April</option>
								<option value="May">May</option>
								<option value="June">June</option>
								<option value="July">July</option>
								<option value="August">August</option>
								<option value="September">September</option>
								<option value="October">October</option>
								<option value="November">November</option>
								<option value="December">December</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary" onclick="readRecords()">Show Data</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Record</h4>
            </div>
            <div class="modal-body">
				<div class="form-group">
					<label for="code">Code of Account</label>
					<input type="text" id="code" placeholder="Code of Account" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="name">Account Name</label>
					<input type="text" id="name" placeholder="Account Name" class="form-control"/>
				</div>
				<div class="form-group">
                    <label for="type">Account Type</label>
                    <select name="type" id="type" class="form-control">
						<option value="">--</option>
						<option value="Debet">Debet</option>
						<option value="Credit">Credit</option>
					</select>
                </div>
				<div class="form-group">
					<label for="balance">Balance of Account</label>
					<input type="text" id="balance" placeholder="Balance of Account" class="form-control"/>
				</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Add Record</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal - Update User details -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body">
				<div class="form-group">
						<label for="update_code">Code of Account</label>
						<input type="text" id="update_code" placeholder="Code of Account" class="form-control"/>
				</div>
				<div class="form-group">
						<label for="update_name">Name of Account</label>
						<input type="text" id="update_name" placeholder="name" class="form-control"/>
				</div>
				<div class="form-group">
                    <label for="update_type">Account Type</label>
                    <select name="update_type" id="update_type" class="form-control">
						<option value="">--</option>
						<option value="Debet">Debet</option>
						<option value="Credit">Credit</option>
					</select>
                </div>
				<div class="form-group">
						<label for="update_balance">Balance of Account</label>
						<input type="text" id="update_balance" placeholder="Balance of Account" class="form-control"/>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Save Changes</button>
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->
 <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
	<a class="btn btn-primary" href="#page-top">
		<i class="fa fa-chevron-up"></i>
	</a>
</div>
<!-- Jquery JS file -->
 
<!-- Bootstrap JS file -->
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> 
<!-- Custom JS file -->
<script type="text/javascript" src="../js/acct/coa.js"></script>
<script src="../js/freelancer.min.js"></script>
<script src="../js/general.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" ></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'en',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
</body>
</html>