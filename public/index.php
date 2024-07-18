<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

display_login_form();

//https://huemint.com/bootstrap-plus/

include "header.php";
?>

<div class="container-md content">
  <div class="row">
    <div class="col-xl-12 col-md-12">
      <div class="card overflow-hidden bg-c-orange">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <i class="icon-pencil primary font-large-2 mr-2"></i>
              </div>
              <div class="media-body">
                <div style="float: right; text-align: right">
                  <span><i class="fas fa-calendar-alt me-2"></i>24 June 2023</span><br />
                  <h2>
                    <i class="me-2" data-lucide="users-round"></i>:
                    <span class="circle-singleline">                      
                        5
                    </span>
                    </h2>
                    <h3>Site: EMSD HQ G/F Demo area</h3>                  
                </div>

                <div class="align-self-center large-bg" style="margin: -23px -200px -60px -5px; float: left;">                  
                  <i class="me-2 large-bg" data-lucide="map-pin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <?php

    //https://lucide.dev/icons/wifi

      $card_array = array();
      $card_array[] = array(
        'wifi',
        'Status :',
        'Normal',
        'Signal connection',
        'bg-c-green',
        'normal'
      );

      $card_array[] = array(
        'hard-hat',
        'Count : ',
        '0',
        'PPE Detection',
        'bg-c-yellow',
        'normal'
      );
      
      $card_array[] = array(
        'flame',
        'Count : ',
        '0',
        'Fire & Smoke Detection',
        'bg-c-red',
        'normal'
      );
      
      $card_array[] = array(
        'cigarette',
        'Count : ',
        '5',
        'Smoking Detection',
        'bg-c-pink',
        'alarm'
      );
      
      $card_array[] = array(
        'construction',
        'Count : ',
        '0',
        'Trespass Detection',
        'bg-c-purple',
        'normal',
      );
      
      $card_array[] = array(
        'heater',
        'Count : ',
        '0',
        'Hotwork Detection',
        'bg-c-blue',
        'normal'
      );      

      $card_array[] = array(
        'thermometer-sun',
        'Temp : ',
        '30 &deg;C',
        'Heat Stress',
        'bg-c-cyan',
        'normal'
      );      
      


    ?>

    <? foreach ($card_array as $this_card) { ?>

      <div class="col-6 col-md-4">
        <div class="card <?=$this_card[4]?> <?=$this_card[5]?> small-cards">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center large-bg">                  
                  <i class="me-2 large-bg" data-lucide="<?=$this_card[0]?>"></i>
                </div>
                <div class="media-body text-right">
                  <h3><?=$this_card[1]?> <span class="circle-singleline"> <?=$this_card[2]?></span></h3>
                  <span><?=$this_card[3]?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <? }  ?>


    
  </div>

  <div class="grey-bg container-fluid" style="display: none;">
    <section id="minimal-statistics">

      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card bg-c-pink">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">156</h3>
                  <span>New Comments</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-bubbles warning font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-cup success font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="danger">423</h3>
                  <span>Total Visits</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-direction danger font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      https://codepen.io/lesliesamafful/details/oNXgmBG
    </section>
    
  </div>
</div>
<script>

function resize_small_cards() {
  // Find the maximum height of the small-cards
  var maxHeight = 0;
  $(".small-cards").each(function() {
    var cardHeight = $(this).height();
    if (cardHeight > maxHeight) {
      maxHeight = cardHeight;
    }
  });

  // Set the height of all small-cards to the maximum height
  $(".small-cards").height(maxHeight);
}

$(document).ready(function() {
  resize_small_cards();
} );
// Resize the small cards on window resize
$(window).resize(function() {
  resize_small_cards();
});

    
</script>
<? include "footer.php"; ?>