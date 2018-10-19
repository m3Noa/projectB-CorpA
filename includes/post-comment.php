<?php
// only a simple text form. To Do: implement a more advanced text editor
?>
<div>
	<h5><?php echo (empty($action)) ? "Post new comment:" : $action;?></h5>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="comment-post" method="post" id="comment-post">
		<fieldset>
			<div class="form-group <?php echo (!empty($cmt_err)) ? 'has-error' : ''; ?>">
				<input type="hidden" id="file-id" name="file-id" value="<?php echo $fileid; ?>">
				<input type="hidden" id="filename" name="filename" value="<?php echo $filename; ?>">
				<input type="hidden" id="username" name="username" value="<?php echo $username; ?>">
				<textarea rows="10" name="content" id="content" class="form-control" autofocus /><?php if(!empty($comt_content)) echo $comt_content; ?></textarea>
				<span class="help-block"><?php echo $cmt_err; ?></span>
			</div>

			<div class="form-group">
				Rating: <select id="rating" name="rating" form="comment-post">
				  <option value="0">Select...</option>
				  <option value="1">Terible</option>
				  <option value="2">Bad</option>
				  <option value="3">Ok</option>
				  <option value="4">Good</option>
				  <option value="5">Excellent</option>
				</select>
			</div>
			<div class="inside_form_buttons">
				<button type="submit" id="submit" class="btn btn-wide btn-primary">Post Comment</button>
			</div>
			<p><?php echo (!empty($sql_err)) ? $sql_err : ''; echo (!empty($note)) ? $note : '';  ?></p>
		</fieldset>
	</form>
</div>
<hr>