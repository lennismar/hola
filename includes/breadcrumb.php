<ol class="breadcrumb only-tablet-to-desktop">
	<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $lng."/";?>"  itemprop="url"><span itemprop="title">Inicio</span></a></li>
	<li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $lng."/".URL_SEARCH."/".GetURLProvincia($breadcrumb_pvid);?>"  itemprop="url"><span itemprop="title"><?php echo GetTitleProvincia($breadcrumb_pvid); ?></span></a></li>
	<li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $lng.'/'.URL_SEARCH.'/'.GetURLProvincia($breadcrumb_pvid).'/'.GetURLComarca($breadcrumb_comid); ?>"  itemprop="url"><span itemprop="title"><?php echo GetTitleComarca($breadcrumb_comid); ?></span></a></li>
	<?php if ($breadcrumb_lid!="") { ?>
    <li class="current" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title"><?php echo GetTitleLocalitat($breadcrumb_lid); ?></span></li>
	<?php } ?>
</ol>