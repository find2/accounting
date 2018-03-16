<?php
session_start();

error_reporting(0);
if ($_SESSION['level']== "")
{
   header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Widhi Sastra Nugraha</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="images/icon1.png">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>    
        .panel-default>.panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #e4e5e7;
        padding: 0;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        }

        .panel-default>.panel-heading a {
        display: block;
        padding: 10px 15px;
        }

        .panel-default>.panel-heading a:after {
        content: "";
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        float: right;
        transition: transform .25s linear;
        -webkit-transition: -webkit-transform .25s linear;
        }

        .panel-default>.panel-heading a[aria-expanded="true"] {
        background-color: #eee;
        }

        .panel-default>.panel-heading a[aria-expanded="true"]:after {
        content: "\2212";
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        }

        .panel-default>.panel-heading a[aria-expanded="false"]:after {
        content: "\002b";
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
        }

        .accordion-option {
        width: 100%;
        float: left;
        clear: both;
        margin: 15px 0;
        }

        .accordion-option .title {
        font-size: 20px;
        font-weight: bold;
        float: left;
        padding: 0;
        margin: 0;
        }

        .accordion-option .toggle-accordion {
        float: right;
        font-size: 16px;
        color: #6a6c6f;
        }

        .accordion-option .toggle-accordion:before {
        content: "Expand All";
        }

        .accordion-option .toggle-accordion.active:before {
        content: "Collapse All";
        }
    </style>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">Widhi Sastra Nugraha</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form action="login.php" method="post" role="form">
				<ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <button type="submit" class="btn btn-danger btn-md" name="logout-btn" >Logout</button>
                    </li>
				</ul>
				</form>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
	
    <section class="success">
		<!-- <div class="row">
			<img class="profile-img img-responsive" src="images/yayasan.png"
                    alt="">
		</div> -->
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
                    <div class="accordion-option">
                        <h3 class="title">Pembukuan</h3>
                        <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Operational MAA
                                </a>
                            </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/coa.php?ledger=1" target="_blank">Chart Of Account</a></li>
                                        <li><a href="accounting/cash.php?ledger=1" target="_blank">Cash</a></li>
                                        <li><a href="accounting/bank.php?ledger=1" target="_blank">Bank</a></li>
                                        <li><a href="accounting/adjustment.php?ledger=1" target="_blank">Adjustment</a></li>
                                        <li><a href="accounting/journal.php?ledger=1" target="_blank">Journal</a></li>
                                        <li><a href="accounting/pl.php?ledger=1" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=1" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=1" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Monarch Shop
                                </a>
                            </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="col-lg-6">
                                        <ul>                                    
                                            <li><a href="accounting/coa.php?ledger=2" target="_blank">Chart Of Account</a></li>
                                            <li><a href="accounting/cash.php?ledger=2" target="_blank">Cash</a></li>
                                            <li><a href="accounting/bank.php?ledger=2" target="_blank">Bank</a></li>
                                            <li><a href="accounting/adjustment.php?ledger=2" target="_blank">Adjustment</a></li>
                                            <li><a href="accounting/journal.php?ledger=2" target="_blank">Journal</a></li>
                                            <li><a href="accounting/pl.php?ledger=2" target="_blank">Profit and Loss</a></li>
                                            <li><a href="accounting/ns.php?ledger=2" target="_blank">Neraca Saldo</a></li>
                                            <li><a href="accounting/nrc.php?ledger=2" target="_blank">Neraca</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul>                                    
                                            <li><a href="accounting/shop/supplier.php" target="_blank">Supplier</a></li>
                                            <li><a href="accounting/shop/item-master.php" target="_blank">Item Master</a></li>
                                            <li><a href="accounting/shop/item-stock.php" target="_blank">Item Stock</a></li>
                                            <li><a href="accounting/shop/po-invoice.php" target="_blank">Pre Order - Invoice</a></li>
                                            <li><a href="accounting/shop/billing.php" target="_blank">Billing</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                Yayasan Lisensi
                                </a>
                            </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/coa.php?ledger=3" target="_blank">Chart Of Account</a></li>
                                        <li><a href="accounting/cash.php?ledger=3" target="_blank">Cash</a></li>
                                        <li><a href="accounting/bank.php?ledger=3" target="_blank">Bank</a></li>
                                        <li><a href="accounting/adjustment.php?ledger=3" target="_blank">Adjustment</a></li>
                                        <li><a href="accounting/journal.php?ledger=3" target="_blank">Journal</a></li>
                                        <li><a href="accounting/pl.php?ledger=3" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=3" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=3" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                LSP LPK Monarch Bali
                                </a>
                            </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/coa.php?ledger=4" target="_blank">Chart Of Account</a></li>
                                        <li><a href="accounting/cash.php?ledger=4" target="_blank">Cash</a></li>
                                        <li><a href="accounting/bank.php?ledger=4" target="_blank">Bank</a></li>
                                        <li><a href="accounting/adjustment.php?ledger=4" target="_blank">Adjustment</a></li>
                                        <li><a href="accounting/journal.php?ledger=4" target="_blank">Journal</a></li>
                                        <li><a href="accounting/pl.php?ledger=4" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=4" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=4" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                LSP PNI
                                </a>
                            </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/coa.php?ledger=5" target="_blank">Chart Of Account</a></li>
                                        <li><a href="accounting/cash.php?ledger=5" target="_blank">Cash</a></li>
                                        <li><a href="accounting/bank.php?ledger=5" target="_blank">Bank</a></li>
                                        <li><a href="accounting/adjustment.php?ledger=5" target="_blank">Adjustment</a></li>
                                        <li><a href="accounting/journal.php?ledger=5" target="_blank">Journal</a></li>
                                        <li><a href="accounting/pl.php?ledger=5" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=5" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=5" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                Wisuda
                                </a>
                            </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/coa.php?ledger=6" target="_blank">Chart Of Account</a></li>
                                        <li><a href="accounting/cash.php?ledger=6" target="_blank">Cash</a></li>
                                        <li><a href="accounting/bank.php?ledger=6" target="_blank">Bank</a></li>
                                        <li><a href="accounting/adjustment.php?ledger=6" target="_blank">Adjustment</a></li>
                                        <li><a href="accounting/journal.php?ledger=6" target="_blank">Journal</a></li>
                                        <li><a href="accounting/pl.php?ledger=6" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=6" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=6" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingSeven">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                Konsolidasi
                                </a>
                            </h4>
                            </div>
                            <div id="collapseSeven" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingSeven">
                                <div class="panel-body">
                                    <ul>                                    
                                        <li><a href="accounting/pl.php?ledger=7" target="_blank">Profit and Loss</a></li>
                                        <li><a href="accounting/ns.php?ledger=7" target="_blank">Neraca Saldo</a></li>
                                        <li><a href="accounting/nrc.php?ledger=7" target="_blank">Neraca</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div> 
	</section>
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
<!-- Portfolio Modals -->
    
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Portfolio Modals -->
    

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>
    <script>
        $(document).ready(function() {

        $(".toggle-accordion").on("click", function() {
            var accordionId = $(this).attr("accordion-id"),
            numPanelOpen = $(accordionId + ' .collapse.in').length;
            
            $(this).toggleClass("active");

            if (numPanelOpen == 0) {
            openAllPanels(accordionId);
            } else {
            closeAllPanels(accordionId);
            }
        })

        openAllPanels = function(aId) {
            console.log("setAllPanelOpen");
            $(aId + ' .panel-collapse:not(".in")').collapse('show');
        }
        closeAllPanels = function(aId) {
            console.log("setAllPanelclose");
            $(aId + ' .panel-collapse.in').collapse('hide');
        }
            
        });
    </script>
</body>

</html>
