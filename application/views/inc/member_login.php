<form class="form-signin" method="post" action="<?php echo site_url('/');?>members/login">
        
        <h5 class="form-signin-heading">Please sign in</h5>
          <?php if(isset($error)){ ?>
            <div class="alert alert-error">
             <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $error; ?>
            </div>
            <?php
            }//end error
            if(isset($basicmsg)){ ?>
            <div class="alert alert-success">
             <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $basicmsg; ?>
            </div>
            <?php
            }
            ?>                  
        <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
        <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        
        <button class="btn btn-inverse pull-right" type="submit"><i class="icon-lock icon-white"></i> Sign in</button>
        <div class="clearfix" style="height:20px;">&nbsp;</div>
</form>