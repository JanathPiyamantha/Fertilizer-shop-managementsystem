<?php
    // Start the sessiom
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

      $user = $_SESSION['user'];

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
	    <div class="dashboard_content">
		    <div class="dashboard_content_main">
			<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
	Our pie chart visually represents the distribution of fertilizer sales across different product categories. 
	Each slice of the pie corresponds to a specific fertilizer product, with the size of the slice proportional to the percentage of sales attributed to that product
    </p>
</figure>
		    </div>
	    </div>
     </div>
  <script src="js/script.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
	Highcharts.chart('container', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Purchase Orders by Status'
    },
    tooltip: {
        valueSuffix: '%'
    },
    subtitle: {
        text:
        'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
    },
    plotOptions: {
        series: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: [{
                enabled: true,
                distance: 20
            }, {
                enabled: true,
                distance: -40,
                format: '{point.percentage:.1f}%',
                style: {
                    fontSize: '1.2em',
                    textOutline: 'none',
                    opacity: 0.7
                },
                filter: {
                    operator: '>',
                    property: 'percentage',
                    value: 10
                }
            }]
        }
    },
    series: [
        {
            name: 'Percentage',
            colorByPoint: true,
            data: [
                {
                    name: 'Fertilizer C',
                    y: 55.02
                },
                {
                    name: 'Fertilizer D',
                    sliced: true,
                    selected: true,
                    y: 26.71
                },
                {
                    name: 'Fertilizer A',
                    y: 1.09
                },
                {
                    name: 'Fertilizer B',
                    y: 15.5
                },
                
            ]
        }
    ]
});

	</script>


  <script>
    	var sideBarIsOpen = true;

    	toggleBtn.addEventListener( 'click', (event) => {
    		event.preventDefault();

    	if (sideBarIsOpen) {
    		dashboard_sidebar.style.width = '10%';
    		dashboard_sidebar.style.transition = '0.3s all';
    		dashboardMainContainer.style.width = '90%';
    		dashboard_logo.style.fontsize = '60px';
    		userImage.style.width = '60px';

    		menuIcons = document.getElementByClassName('menuText');
    		for (var i = 0; i<menuIcons.length;i++){
    			menuIcons[i].style.display = 'none';
    		}
    		document.getElementByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
    		 sideBarIsOpen = false;
    	}else{
    			dashboard_sidebar.style.width = '20%';
    		    dashboardMainContainer.style.width = '80%';
    		    dashboard_logo.style.fontsize = '80px';
    		    userImage.style.width = '80px';

    		    menuIcons = document.getElementByClassName('menuText');
    		    for (var i = 0; i<menuIcons.length;i++){
    			menuIcons[i].style.display = 'inline-block';
    		    }
    		    document.getElementByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
    		    sideBarIsOpen = true;
    		  }

    	});

  </script>
</body>
</html>