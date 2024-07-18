<?php
include "header.php";
?>

<? if ( isset($_SESSION)) { ?>
  <div class="container-md my-3">
  
  <div class="d-flex" style="float: right;">

    <? if ( isset($_SESSION['access'] ) && $_SESSION['access'] === "admin") { ?>
      <a href="list-all-zones.php" class="btn btn-info">List all Serials</a> &nbsp;
    <? } ?>    

    <? if ( isset ( $_SESSION['admin_user'] ) ) { ?>
      <a href="/?logout=now" class="btn btn-warning">Logout: <?=$_SESSION['admin_user']?></a>
    <? } ?>
  </div>  
</div>  
<? } ?>


<div class="container-md my-3 content">

		<form method="post">

    <div class="mb-3 row justify-content-center form-group">
      <div class="col-9"> 
          <h2>AI Safety Portal Login</h2>
      </div>
    </div>

    <div class="errors mb-3 row justify-content-center">
        <div class="col-9">
            <? display_errors(); ?>       
        </div>
    </div>
    
		<div class="mb-3 row justify-content-center form-group">
			<label for="staticEmail" class="col-3 col-form-label">Login name:</label>
			<div class="col-6">
			<input type="text" name="username"  class="form-control" required>
			</div>
		</div>
		<div class="mb-3 row justify-content-center form-group">
			<label for="inputPassword" class="col-3 col-form-label">Password：</label>
			<div class="col-6">
			<input type="password" name="password" class="form-control" id="inputPassword" required>
			</div>
		</div>
				

		<div class="mb-3 row justify-content-center form-group">
      <label for="" class="col-2 col-form-label"></label>
      <div class="col-6">
          <input class="btn btn-warning" type="submit" value="登入" />        
      </div>
		</div>
        
    <input type="hidden" name="return" value="<?=isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : "" ?>" />
		</form>
</div>
<?php
include "footer.php";
?>
