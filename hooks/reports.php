<?php
	define('PREPEND_PATH', '../');
	$app_dir = dirname(__FILE__) . '/..';
	include("$app_dir/defaultLang.php");
	include("$app_dir/language.php");
	include("$app_dir/lib.php");

	include_once("$app_dir/header.php");

	/* first and last year for year drop down */
	$first_year = substr(sqlValue("select min(date_due) from invoices"), 0, 4);
	$last_year = substr(sqlValue("select max(date_due) from invoices"), 0, 4);
?>

<link rel="stylesheet" href="resources/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
<script src="resources/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<div class="page-header"><h1>Invoicing Reports</h1></div>


<div class="row">
	<div class="button-grid-classes">
		<button id="search_by_customer" type="button" class="button-classes" data-toggle="modal" data-target="#myModal">
			<i class="glyphicon glyphicon-search"></i> Search By Customer Name
		</button>
	</div>
	<div class="button-grid-classes">
		<a class="button-classes" href="due_invoices.php">
			<i class="glyphicon glyphicon-search"></i> All Due Invoices
		</a>
	</div>
	<div class="button-grid-classes">
		<a class="button-classes" href="upcoming_invoices.php">
			<i class="glyphicon glyphicon-search"></i> All Upcoming Invoices
		</a>
	</div>
	<div class="button-grid-classes">
		<a href="overdue_invoices.php" class="button-classes">
			<i class="glyphicon glyphicon-search"></i> All Overdue Invoices
		</a>
	</div>
	<div class="button-grid-classes">
		<a href="upcoming_and_due_invoices.php" class="button-classes">
			<i class="glyphicon glyphicon-search"></i> Upcoming And Due Invoices
		</a>
	</div>
	<div class="button-grid-classes">
		<button id="search_by_year" type="button" 
			class="button-classes" data-toggle="modal" 
			data-target="#myModal3"><i class="glyphicon glyphicon-search"></i> Search By Year</button>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Search All invoice of a certain customer </h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <form action="search_by_name.php" method="get">
                        <div class="form-group">
                            Search Customer Name :  <select name="search"  id="CategoryDropDown"> 
								<?php
								$customer_name = sql("select id ,name from clients ", $e0);
								echo "<option value=' '> </option>";
                                
								while ($row = mysqli_fetch_assoc($customer_name)) {
									echo  "<option value='" . $row ['id'] . "'>" . $row['name'] . "</option>";
								}
								?>
                            </select>  <br><br>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Search By Year </h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <form action="search_by_year.php" method="post">

                        <div class="form-group">
                            Search By Year
                            <select id="year" name="search"></select>
                            <br><br>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>
	/* populate #year drop-down */
	var start = <?php echo $first_year; ?>;
	var end = <?php echo $last_year; ?>;
	var options = "<option value=''> </option>";
	var year = 0;
	for (year = start; year <= end; year++) {
		options += '<option value=' + year + '>' + year + "</option>";
	}
	document.getElementById("year").innerHTML = options
</script>




<script>
	$j(function () {
		$j('#CategoryDropDown').select2();
		$j('#year').select2();

		<?php if(isset($_REQUEST['search_by_customer'])){ ?>
			$j('#search_by_customer').click();
		<?php } ?>

		<?php if(isset($_REQUEST['search_by_year'])){ ?>
			$j('#search_by_year').click();
		<?php } ?>

		/*
		$j('#from-date, #to-date').datepicker({
			autoclose: false,
			format: 'yyyy-mm-dd',
			orientation: 'down'
		});

		$j('#from-date').change(function () {
			$j('#to-date').datepicker('setStartDate', $j('#from-date').val());

			var df = new Date($j('#from-date').datepicker('getDate'));
			df.setMonth(df.getMonth() + 1);
			$j('#to-date').datepicker('setDate', df);
		});
		*/
		
		/* replace .button-classes and .button-grid-classes */
		$j('.button-classes').addClass('btn btn-info btn-lg btn-block');
		$j('.button-grid-classes').addClass('col-xs-6 col-sm-4 col-md-3 col-lg-2');
	})
</script>


<style>
	.button-classes{
		height: 6em;
		white-space: normal;
		margin: .5em;
	}
	a.button-classes{
		padding-top: 2.25em !important;
	}
</style>

<?php include_once("$app_dir/footer.php"); ?>