<?
include 'phmagick.php';

$phMagick = new phMagick('9f3848e89675.jpg','resize.jpg');
//$phMagick->setImageMagickPath('/usr/local/bin');
$phMagick->setImageQuality(95);
//$phMagick->resize(400,0); // the same as resize(200,0)
$phMagick->resizeExactly(400,400); // the same as resize(200,0)
//$phMagick->sharpen();
$phMagick->unsharp(0.5,1.0,0.8,0.05);





$phMagick->debug=true;


?>

<img src="resize.jpg?d=<?=mt_rand(0,10000)?>" />
<pre><? print_r($phMagick->getLog()) ?></pre>