<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
        <fieldset>
        <legend>Editera en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doSave' value='Spara' onClick="this.form.action = '<?=$this->url->create('comment/save/'.$key.'/'.$id)?>'"/>
            <input type='submit' name='doDelete' value='Ta bort' onClick="this.form.action = '<?=$this->url->create('comment/delete/'.$key.'/'.$id)?>'"/>
        </p>
        </fieldset>
    </form>
</div>
