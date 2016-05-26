<img class='sitelogo' src='<?=$this->url->asset("img/logo.png")?>' alt='Logo'/>
<span class='sitetitle'><?=$siteTitle?></span><br>

<?php if ($this->views->hasContent('navbar')) : ?>
	<div id='navbar'>
        <?php $this->views->render('navbar')?>
    </div>
<?php endif; ?>

<span class='siteslogan'><?=$siteTagline?></span>
