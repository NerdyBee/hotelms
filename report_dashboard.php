
<body>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
                <!-- <form id="report-form" method="POST">
                    <div>
                        <label for="month">What month would you like to see report for (January to December)?</label>
                        <input id="month" type="month" name="month" min="2024-01" required />
                        <span class="validity"></span>
                        <input type="button" value="Search" onclick="submitForm()" />
                    </div>
                </form> -->
                <form id="report-form" method="POST">
                    <div>
                        <label for="month">What month would you like to see report for (January to December)?</label>
                        <!-- Set default value to present month and year -->
                        <input id="month" type="month" name="month" min="2024-01" value="<?php echo date('Y-m'); ?>" required />
                        <span class="validity"></span>
                        <input type="button" value="Search" onclick="submitForm()" />
                    </div>
                </form>

			</ol>
		</div><!--/.row-->
		
		<!-- <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div>/.row -->
		
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding">
                            <div id="bar-sales" class="large"></div>
                            <div class="text-muted">Bar Sales</div>
                        </div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding">
							<div id="kitchen-sales" class="large"></div>
							<div class="text-muted">Kitchen Sales</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding">
							<div  id="laundry-sales" class="large"></div>
							<div class="text-muted">Laundry Sales</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding">
							<div id="gym-sales" class="large"></div>
							<div class="text-muted">Gym/Pool Sales</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->

			<hr>

			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding">
							<div  id="booking-sales" class="large"></div>
							<div class="text-muted">Room Payments</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-check-circle color-green"></em>
							<div id="booking_count"class="large"></div>
							<div class="text-muted">Booked Rooms</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-check-square-o color-magg"></em>
							<div id="hall_payment" class="large"></div>
							<div class="text-muted">Hall Payment</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-spinner color-blue"></em>
							<div id="hall_count" class="large"></div>
							<div class="text-muted">Total Hall Booking</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->

			<hr>

			<div class="row">
				<div class="col-xs-6 col-md-2 col-lg-2 no-padding">
					
				</div>

				<div class="col-xs-6 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-red panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-money color-red"></em>
							<div id="tt_earn" class="large"></div>
							<div class="text-muted">Total Earnings</div>
						</div>
					</div>
				</div>
				<!-- <div class="col-xs-6 col-md-4 col-lg-4 no-padding">
					<div class="panel panel-orange panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-credit-card color-purp"></em>
							<div class="large">₦<-?php include 'counters/pendingpayment.php'?></div>
							<div class="text-muted">Pending Payment</div>
						</div>
					</div>
				</div> -->
				<div class="col-xs-6 col-md-2 col-lg-2 no-padding">
					
				</div>
			</div><!--/.row-->
		</div>
		
	</div>	<!--/.main-->
	

		
</body>
</html>

<script>
    // Function to submit the form asynchronously
    function submitForm() {
        var formData = new FormData(document.getElementById("report-form"));
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    // Update the result section with the received data
                    document.getElementById("bar-sales").innerHTML = data.bar_sales;
                    document.getElementById("kitchen-sales").innerHTML = data.kitchen_sales;
                    document.getElementById("laundry-sales").innerHTML = data.laundry_sales;
                    document.getElementById("gym-sales").innerHTML = data.gym_sales;
                    document.getElementById("booking-sales").innerHTML = data.payment_history;
                    document.getElementById("booking_count").innerHTML = data.book_count;
                    document.getElementById("hall_payment").innerHTML = data.hall_sales;
                    document.getElementById("hall_count").innerHTML = data.hall_count;
                    document.getElementById("tt_earn").innerHTML = data.total_earnings;
                } else {
                    console.error("Failed to fetch data.");
                }
            }
        };
        xhr.open("POST", "report/bar.php", true);
        xhr.send(formData);
    }

    // Submit the form when the page loads
    window.onload = function() {
        submitForm();
    };
</script>
