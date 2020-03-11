<?php include 'includes/document_head.php'?>
		<div id="wrapper">	
			<?php include 'includes/topbar.php'?>		
			<?php include 'includes/sidebar.php'?>
			<div id="main_container" class="main_container container_16 clearfix">
				<?php include 'includes/navigation.php'?>
				<div class="flat_area grid_16">
					<h2>Step by Step Wizard</h2>
					<p>Here we have the two most popular and powerful WYSIWYG text/HTML editors - CKeditor and Tiny Editor.</p>
				</div>
				<div class="box grid_16">
					<h2 class="box_head grad_colour round_top">Wizard</h2>
					<div class="toggle_container wizard">		
						<div id="progressbar" class="progress_in_header"><span>Progress</span></div>
						<div class="wizard_steps">
							<ul class="clearfix">
								<li class="current">
									<a href="#step_1" class="clearfix">
										<span>1. <strong>Register</strong></span>
										<small>It only takes a minute</small>
									</a>
								</li>
								<li>
									<a href="#step_2" class="clearfix">
										<span>2. <strong>Information</strong></span>
										<small>Fill out our form</small>
									</a>
								</li>
								<li>
									<a href="#step_3" class="clearfix">
										<span>3. <strong>Another Step</strong></span>
										<small>Were nearly there</small>
									</a>
								</li>
								<li>
									<a href="#step_4" class="clearfix">
										<span>4. <strong>Finish</strong></span>
										<small>Confirm and complete</small>
									</a>
								</li>
							</ul>		
						</div>
					</div>
						<div class="block grid_16 alpha omega wizard_content">
							<div id="step_1" class="step" style="display:block;">
								<h1>1. Register</h1>
								<hr class="grid_16 alpha omega">
								<form>
									<fieldset class="grid_8 alpha">
										<label>Small input form</label> 
										<input title="This field has an HTML5 autofocus property" type="text" class="small required" autofocus> 
						
										<label>Medium input form</label> 
										<input title="This is a tool tip" type="text" class="medium">
															
										<label>Long input form</label> 
										<input title="A tooltip can be set on any object by giving it a title property" type="text" class="large"> 
									</fieldset>
								
									<fieldset class="grid_8 omega">		
										<label>Regular Text Area</label> 
										<textarea class="grid_16"></textarea> 
									</fieldset>
									
									<hr class="grid_16 alpha omega">
								
									<button class="next_step button_colour round_all" id="step_2"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Next Step</span></button>
								</form>
							</div>

							<div id="step_2" class="step">
								<h1>2. Information</h1>
								<hr class="grid_16 alpha omega">
								<form>
									<fieldset class="grid_8 alpha">
										<label>Small input form</label> 
										<input title="This field has an HTML5 autofocus property" type="text" class="small required" autofocus> 

										<label>Medium input form</label> 
										<input title="This is a tool tip" type="text" class="medium">

										<label>Long input form</label> 
										<input title="A tooltip can be set on any object by giving it a title property" type="text" class="large"> 
									</fieldset>

									<fieldset class="grid_8 omega">		
										<label>Regular Text Area</label> 
										<textarea class="grid_16"></textarea> 
									</fieldset>

									<hr class="grid_16 alpha omega">

									<button class="next_step button_colour round_all" id="step_3"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Next Step</span></button>
								</form>
							</div>		
						
							<div id="step_3" class="step">
								<h1>3. Another Step</h1>
								<hr class="grid_16 alpha omega">
								<form>
									<fieldset class="grid_8 alpha">
										<label>Small input form</label> 
										<textarea class="grid_16"></textarea>
									</fieldset>

									<hr class="grid_16 alpha omega">

									<button class="next_step button_colour round_all" id="step_4"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Next Step</span></button>
								</form>								
							</div>	
							
							<div id="step_4" class="step">
								<h1>4. Finish</h1>
								<hr class="grid_16 alpha omega">
								<form>
									<fieldset class="grid_8 alpha">
										<label>Small input form</label> 
										<textarea class="grid_16"></textarea>
									</fieldset>

									<hr class="grid_16 alpha omega">

									<button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Finish</span></button>
								</form>								
							</div>											
						</div>
					</div>
				</div>
			</div>
		</div>
		
<script type="text/javascript">

// wizard

	$('.wizard_steps ul li a').click(function(){
	
		$('.wizard_steps ul li').removeClass('current');
		$(this).parent('li').addClass('current');
		
		var step = $(this).attr('href');
		var step_num = $(this).attr('href').replace('#step_','');
		var step_multiplyby = (100 / $(".wizard_steps > ul > li").size());
		var prog_val = (step_num*step_multiplyby);
		
		$( "#progressbar").progressbar({ value: prog_val });
		
		$('.wizard_content').children().hide();
		$('.wizard_content').children(step).fadeIn();
		
		return false;
	});
	
	$('button.next_step').click(function(){
		
		var step = $(this).attr('id');
		var hash_step = ('#'+step);
				
		var step_num = $(this).attr('id').replace('step_','');
		var step_multiplyby = (100 / $(".wizard_steps > ul > li").size());
		var prog_val = (step_num*step_multiplyby);
		
		$( "#progressbar").progressbar({ value: prog_val });
		
		$('.wizard_steps ul li').removeClass('current');
		$('a[href='+ hash_step +']').parent().addClass('current');
		
		$('.wizard_content').children().hide();
		$('.wizard_content').children(hash_step).fadeIn();
		
		return false;		
	});
	
</script>

<?php include 'includes/closing_items.php'?>