<?php $id=$_GET["id"] ;?>

<?php 
include 'includes/checkuser.php';
include 'includes/document_head.php';

if ($_SESSION['type_user']=='propietario') {
	if ($_SESSION['eid'] != $id) header('location: index.php');
}
?>

		<div id="wrapper">
			<?php include 'includes/topbar.php' ?>		
			<?php include 'includes/sidebar.php' ?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php //include 'includes/navigation.php'?>
				<div class="flat_area grid_16">
					<h2>Galeria d'imatges - <?php echo Query('establiments', 'title', 'eid', $id); ?></h2>
                    <form>
                        <div id="uploader">
                            <p>El seu navegador no suporta Flash, Silverlight, Gears, BrowserPlus o HTML5.</p>
                        </div>
                    </form>
                    <br><br>
                    
					<div class="indent gallery">
						<ul class="clearfix">
                                <?php
                                    //$rs_query = mysqli_query("SELECT eid, filename, principal FROM establiments_images WHERE eid=".$id);
                                    $db->where('eid',$id);
                                    $rs_query=$db->get('establiments_images',null,'eid, filename, principal');
                                    $img = 1;
                                    //while($rs = mysqli_fetch_array($rs_query)){
                                    foreach ($rs_query as $rs) {
                                                            # code...

                                ?>
                            <li data-id="bl<?php echo $img; ?>" data-type="blue">
                                <a rel="collection" href="<?php echo CDN_BASE; ?>images/uploads/establiments/<?php echo $rs['filename']; ?>">
                                	<img src="<?php echo CDN_BASE; ?>images/uploads/establiments/<?php echo $rs['filename']; ?>" width="150" height="80"/>
                                </a>
                                <br>
                                <button class="skin_colour round_all" style="clear:none" onClick="javascript:if(confirm('Estas segur de que la vols eliminar?')){ window.location = 'images_act.php?action=del&filename=<?php echo $rs['filename'];?>&eid=<?php echo $id;?>'; }">Eliminar</button>
                                <!--<button class="skin_colour round_all" style="clear:none" onClick="window.open('images_crop.php?filename=<?php echo $rs['filename'];?>&eid=<?php echo $id;?>','_blank','width=870, height=620,status=no,scrollbars=1');">Editar</button>-->
                            	<button class="skin_colour <?php if ($rs['principal']) { echo "orange"; } ?> round_all" style="clear:none" onClick="javascript:if(confirm('Seleccionar aquesta imatge com a principal?')){ window.location = 'images_act.php?action=principal&filename=<?php echo $rs['filename'];?>&eid=<?php echo $id;?>'; }">Destac</button>
                            </li>
<?php 
		$img++;
	} 

?>                    	
                        </ul>
					</div>

                    <div class="flat_area grid_16">
                        <p>
						<?php
    
                        if ($_SESSION['type_user']=='superadmin') { ?>
                        <div class="flat_area grid_16">
                            <p>
                                <button class="button_colour orange round_all" style="clear:none" onClick="javascript:window.location = 'images.php';"><img width="24" height="24" alt="Tornar" src="images/icons/small/white/bended_arrow_left.png"><span>Tornar</span></button>
                            </p>
                        </div>                      
                        <?php
                        }
    
                        ?>                             
                    	</p>
                    </div>                      
				</div>	
            </div>
		</div>

        
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.js"></script>

<script type="text/javascript">	
	
	//FancyBox Config (more info can be found at http://www.fancybox.net/)

		$(".gallery ul li a").fancybox({
	        'overlayColor':'#000' 		
		});
		
		$("a img.fancy").fancybox();
		
</script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	
	var total_upload_files = 0;
	
	$("#uploader").plupload({
		// General settings
		runtimes : 'gears,flash,silverlight,browserplus,html5',
		url : 'upload.php',
		max_file_size : '10mb',
		chunk_size : '1mb',
		unique_names : true,

		// Resize images on clientside if we can
		resize : {width : 1024, quality : 90},
		
		// Sort files
    	sortable: true,
		
		// Enviar id del hotel
		multipart_params: {eid : <?php echo $id; ?>},
	
		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
		],

		// Flash settings
		flash_swf_url : 'js/plupload/js/plupload.flash.swf',

		
		/*
		init : {		
			FileUploaded: function(Up, File, Response) { 
				if( (uploader.total.uploaded + 1) == uploader.files.length)
  				{			
					window.location.reload(); 
				}
			}
		},		
		*/
		
		// Silverlight settings
		silverlight_xap_url : 'js/plupload/js/plupload.silverlight.xap'
	});
	

	
	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').plupload('getUploader');

		// Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });	
			
            uploader.start();
        } else
            alert('You must at least upload one file.');

        return false;
    });
});
</script>
       
<?php include 'includes/closing_items.php'?>