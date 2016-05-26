<h2>Kommentarer</h2>

<?php if (is_array($comments) && !empty($comments)) : ?>
	<div class='comments'>	
		<?php foreach ($comments as $id => $comment) : ?>
			<fieldset>
				<article class="comment">
					<header class="commentHeader">		                    
		               	<div class="commentId"><a href="<?=$this->url->create('comment/edit/'.$key.'/'.$comment->id.'/'.$redirect)?>">#<?=$comment->id?></a></div>
		               	<div class="commentTitle">Kommentar av <a href="mailto:<?=$comment->mail?>"><?=$comment->name?></a> (<span class="commentTime"><?=$comment->timestamp?><span/>)</div>
		            </header>
		            <div class="commentBody">
		                <div><?=$comment->comment?></div>
		            </div>
		            <footer class="commentFooter">
		                <a href="#"><?=$comment->web?></a>
		            </footer>
		        </article>
		    </fieldset>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
