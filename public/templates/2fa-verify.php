<?php
include "header.php";
?>

<div class="container-md my-3">


    <form method="post">

    <div class="mb-3 row justify-content-center form-group">
        <div class="col-md-8">   
            <h2>2FA Verification</h2>
        </div>
    </div>

    <div class="errors mb-3 row justify-content-center">
        <div class="col-md-8">
            <!--<?=$_SESSION['2fa_secret']?>-->
        </div>
    </div>


    <div class="errors mb-3 row justify-content-center">
        <div class="col-md-8">
            <?php   display_errors(); ?>
        </div>
    </div>

    
    <div class="mb-3 row justify-content-center form-group">
        <label for="2fa_code" class="col-sm-2 col-form-label">2FA Code:</label>
        <div class="col-md-6">
        <input type="text" class="form-control" id="2fa_code" name="2fa_code" required>
        </div>
    </div>
				

	<div class="mb-3 row justify-content-center form-group">
      <label for="" class="col-sm-2 col-form-label"></label>
      <div class="col-md-6">
          <input class="btn btn-primary btn-block" type="submit" value="Verify" />        
      </div>
    </div>



    </form>
</div>
<? include "footer.php";
?>