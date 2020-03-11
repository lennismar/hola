<?php $id=$_GET["id"] ;?>

<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';
?>

<!-- Javascript para el calendario -->
<script type="text/JavaScript" src="js/BookingCalendar/js/jquery.dop.BookingCalendar_establimentpreus.js"></script>

<script type="text/JavaScript">
    $(document).ready(function(){
        $('#backend').DOPBookingCalendar({
            'Type':'BackEnd',
            'DataURL': 'js/BookingCalendar/php/load_establimentpreus.php?eid=<?php echo $id; ?>',
            'SaveURL': 'js/BookingCalendar/php/save_establimentpreus.php?eid=<?php echo $id; ?>'
        });
        
        $('#frontend').DOPBookingCalendar({'Type':'FrontEnd'});

        $('#refresh1').click(function(){
            $('#backend').html('');
            $('#backend').DOPBookingCalendar({'Type':'BackEnd'});
        });

        $('#refresh2').click(function(){
            $('#frontend').html('');
            $('#frontend').DOPBookingCalendar({'Type':'FrontEnd'});
        });
    });
</script>  
                
		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php'?>
				<div class="flat_area grid_16">
					<h2>Editar Establiment - <?php echo Query('establiments', 'title', 'eid', $id);?></h2>		
				</div>
                			               
				<div class="box grid_16">
					<div class="toggle_container">
						<div class="block no_padding">
							<ul class="full_width">
                            	<div class="block">
                                    <div id="backend-container">
                                        <div id="backend"></div>
                                    </div>								
                            	</div>
                            </ul>
						</div>
                	</div>
				</div>

            </div>
		</div>
        
<?php include 'includes/closing_items.php'?>