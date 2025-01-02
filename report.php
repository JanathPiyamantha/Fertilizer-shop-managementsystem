<?php
    // Start the sessiom
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

?> 
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - Fertilizer Shop Management System</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>
<body>
	  <div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
	    <?php include('partials/app-topnav.php') ?>
       
        <div id="reportContainer">
            <div class="reportTypeContainer">
                <div class="reportType">
                    <p>Export Products</p>
                <div class="alignRight">
                    <a href="database/report_csv.php?report=product" class="reportExportBtn">Excel</a>
                    <a href="database/report_pdf.php?report=product" target="_blank" class ="reportExportBtn">PDF</a>
                    </div>
                </div>
            
                <div class="reportType">
                    <p>Export Suppliers</p>
                <div class="alignRight">
                    <a href="database/report_csv.php?report=supplier" class="reportExportBtn">Excel</a>
                    <a href="" class="reportExportBtn">PDF</a>
                    </div>
                </div>
            </div>
            <div class="reportTypeContainer">
                <div class="reportType">
                    <p>Export Deliveries</p>
                <div class="alignRight">
                    <a href="database/report_csv.php" class="reportExportBtn">Excel</a>
                    <a href="" class="reportExportBtn">PDF</a>
                    </div>
                </div>
            
                <div class="reportType">
                    <p>Export Orders</p>
                <div class="alignRight">
                    <a href="database/report_csv.php" class="reportExportBtn">Excel</a>
                    <a href="" class="reportExportBtn">PDF</a>
                    </div>
                </div>
            </div>
                </div>
            </div>
         </div>
        </div>

<script src="js/script.js"></script>

</body>
</html>