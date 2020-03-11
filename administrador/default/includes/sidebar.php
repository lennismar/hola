<div id="sidebar">
	<div class="cog">+</div>
	
	<a href="index.php" class="logo"><span>Adminica Pro II</span></a>

	<div class="user_box round_all clearfix">
		<img src="images/profile.jpg" width="55" alt="Profile Pic" />
		<h2>Administrator</h2>
		<h3><a class="text_shadow" href="#">John Smith</a></h3>
		<ul>
			<li><a href="#">settings</a><span class="divider">|</span></li>
			<li><a href="login.php">logout</a></li>
		</ul>
	</div><!-- #user_box -->

	<ul id="accordion" class="round_all">
		<li><a href="index.php" class="top_level has_slide"><img src="images/icons/small/grey/home.png"/>Home</a>
			<ul class="drawer">
				<li><a href="#">Activity</a></li>
				<li><a href="#">Events</a></li>
				<li><a href="#">Tasks</a></li>
			</ul>
		</li>
		<li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/mail.png"/>Mailbox<span class="alert badge alert_red">5</span></a>
			<ul class="drawer">
				<li><a href="#">Inbox<span class="alert badge alert_grey">3</span></a></li>
				<li><a href="#">Sent Items<span class="alert badge alert_grey">2</span></a></li>
				<li><a href="#">Drafts</a></li>
				<li><a href="#">Trash</a></li>
			</ul>
		</li>
		<li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/documents.png"/>Documents<span class="alert badge alert_black">2</span></a>
			<ul class="drawer">
				<li><a href="#">Create New</a></li>
				<li><a href="#">View All</a></li>
				<li><a href="#">Upload/Download<span class="alert badge alert_grey">2</span></a></li>
			</ul>
		</li>
		<li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/users.png"/>Members</a>
			<ul class="drawer">
				<li><a href="#">Add New</a></li>
				<li><a href="#">Edit/Delete</a></li>
				<li><a href="#">Search Profiles</a></li>
			</ul>
		</li>
		<li><a href="#" onClick="parent.location='http://www.tricycle.ie'" class="top_level"><img src="images/icons/small/grey/graph.png"/>Statistics</a></li>
		<li><a href="#" class="top_level has_slide"><img src="images/icons/small/grey/cog_2.png"/>Settings</a>
			<ul class="drawer">
				<li><a href="#">Account</a></li>
				<li><a href="#">System</a></li>
			</ul>
		</li>
	</ul>
	<form id="search_side"><input class="round_all" type="text" value="Search Adminica..." onclick="value=''"></form>
	<ul id="side_links" class="text_shadow round_all" >
		<li><a href="http://www.tricycle.ie/adminica/index.php/docs/">Online Documentation</a>
		<li><a href="#">Expert Forum</a></li>
		<li><a href="#">Product Wiki</a></li>
		<li><a href="#">Latest Company News</a></li>
	</ul>
</div><!-- #sidebar -->
