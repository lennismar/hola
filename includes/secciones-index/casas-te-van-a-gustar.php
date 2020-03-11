<?php
	switch($lng) {
		case 'fr':
			$landing1 = URL_BASE.$lng.'/maisons-rurales/all/all/pers:0/price:all/instant:1';
			$landing2 = URL_BASE.$lng.'/maisons-rurales/all/all/pers:0/price:all/theme:8';
			$landing3 = URL_BASE.$lng.'/maisons-rurales/all/all/pers:0/price:all/theme:2';
			$landing4 = URL_BASE.$lng.'/maisons-rurales/all/all/pers:0/price:all/theme:1';
			$landing5 = URL_BASE.$lng.'/maisons-rurales/girona/garrotxa';
		break;
		case 'en':
			$landing1 = URL_BASE.$lng.'/holiday-cottages/all/all/pers:0/price:all/instant:1';
			$landing2 = URL_BASE.$lng.'/holiday-cottages/all/all/pers:0/price:all/theme:8';
			$landing3 = URL_BASE.$lng.'/holiday-cottages/all/all/pers:0/price:all/theme:2';
			$landing4 = URL_BASE.$lng.'/holiday-cottages/all/all/pers:0/price:all/theme:1';
			$landing5 = URL_BASE.$lng.'/holiday-cottages/girona/garrotxa';
		break;
		case 'ca':
			$landing1 = URL_BASE.$lng.'/cases-rurals/all/all/pers:0/price:all/instant:1';
			$landing2 = URL_BASE.$lng.'/cases-rurals/all/all/pers:0/price:all/theme:8';
			$landing3 = URL_BASE.$lng.'/cases-rurals/all/all/pers:0/price:all/theme:2';
			$landing4 = URL_BASE.$lng.'/cases-rurals/all/all/pers:0/price:all/theme:1';
			$landing5 = URL_BASE.$lng.'/cases-rurals/girona/garrotxa';
		break;
		default:
			$landing1 = URL_BASE.$lng.'/casas-rurales/all/all/pers:0/price:all/instant:1';
			$landing2 = URL_BASE.$lng.'/casas-rurales/all/all/pers:0/price:all/theme:8';
			$landing3 = URL_BASE.$lng.'/casas-rurales/all/all/pers:0/price:all/theme:2';
			$landing4 = URL_BASE.$lng.'/casas-rurales/all/all/pers:0/price:all/theme:1';
			$landing5 = URL_BASE.$lng.'/casas-rurales/girona/garrotxa';
		break;
	}
?>

			<div class="row push--bottom">

			    <div class="col-pad col-pad--half">

				    <a href="<?php echo $landing1;?>">
					    
					    <div class="block-destiny">
		
							<div class="block-destiny-img">
								<img src="<?php echo CDN_BASE; ?>assets/img/foto-plan-01.jpg" alt="<?php echo RESERVA_INMEDIATA; ?>" width="550" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="57" viewBox="0 0 29 57">
  <path fill="#D0021B" fill-rule="evenodd" d="M316.999613,222.103364 C316.746451,221.042838 305.615654,215.894092 305.271189,214.047531 C304.926723,212.200969 331.72447,188.42025 332.276445,189.010817 C332.828419,189.605543 319.091306,211.427409 319.294665,212.217605 C319.493874,213.0078 330.898583,218.347857 331.023089,220.269279 C331.147594,222.19486 304.598859,245.796745 304.017833,245.305993 C303.436807,244.811081 317.248624,223.15973 316.999613,222.103364 Z" transform="translate(-304 -189)"/>
</svg>

							    <h3><?php echo RESERVA_INMEDIATA; ?></h3>
						    </div>							    
					    </div>
				    </a>
				    
			    </div>
			    
			    <div class="col-pad col-pad--half">
			         <a href="<?php echo $landing2;?>">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="<?php echo CDN_BASE; ?>assets/img/foto-plan-02.png" alt="<?php echo HOME_BANNER2; ?>" width="550" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3><?php echo HOME_BANNER2; ?></h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			</div>
			
			<div class="row">

			    <div class="col-pad col-pad--third">
			        <a href="<?php echo $landing3;?>">
					    
					    <div class="block-destiny">
		
							<div class="block-destiny-img">
								<img src="<?php echo CDN_BASE; ?>assets/img/foto-plan-03.png" alt="<?php echo HOME_BANNER3; ?>" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3><?php echo HOME_BANNER3; ?></h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>

			    <div class="col-pad col-pad--third">
			        <a href="<?php echo $landing4;?>">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="<?php echo CDN_BASE; ?>assets/img/foto-plan-04.png" alt="<?php echo HOME_BANNER4; ?>" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3><?php echo HOME_BANNER4; ?></h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			    
			    <div class="col-pad col-pad--third">
			         <a href="<?php echo $landing5;?>">
					    
					    <div class="block-destiny">
						    
						    <div class="block-destiny-img">
								<img src="<?php echo CDN_BASE; ?>assets/img/foto-plan-05.png" alt="<?php echo HOME_BANNER5; ?>" width="360" height="260" />
						    </div>
						    <div class="block-destiny-content">
							    <h3><?php echo HOME_BANNER5; ?></h3>
						    </div>							    
					    </div>
				    </a>	
			    </div>
			    
			</div>