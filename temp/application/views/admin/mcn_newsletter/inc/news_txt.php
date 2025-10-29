<div class="row-fluid">
    <div class="span12">
        <form id="paragraph-update" name="paragraph-update" method="post" action="<?php echo site_url('/');?>newsltetter/update_paragraph_do">
            <input type="hidden" name="newsletter_id"  value="<?php if(isset($newsletter_id)){echo $newsletter_id;}?>">
            <input type="hidden" name="paragraph_id"  value="<?php if(isset($paragraph_id)){echo $paragraph_id;}?>">
            <div class="control-group" id="redactor_content_msg">
                <div class="controls">
                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-inverse btn" id="butt">Update Paragraph</button>
            </div>
        </form>
    </div>
</div>