<h2>Image Left - Text Right</h2>
<div class="row-fluid">
    <div class="span4">
        <?php $this->newsletter_model->get_news_image('left_img', $paragraph_id, 'left'); ?>
    </div>
    <div class="span8">
        <form id="paragraph-update" name="paragraph-update" method="post" action="<?php echo site_url('/');?>newsltetter/update_paragraph_do">
            <input type="hidden" name="newsletter_id"  value="<?php if(isset($newsletter_id)){echo $newsletter_id;}?>">
            <input type="hidden" name="paragraph_id"  value="<?php if(isset($paragraph_id)){echo $paragraph_id;}?>">
                <div class="controls">
                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                </div>
            <br>
            <button type="submit" class="btn btn-inverse btn" id="butt">Update Paragraph</button>
        </form>
     </div>
</div>