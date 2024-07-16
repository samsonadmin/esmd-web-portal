<?php
/*
    +--------------------------------------------------------------------------------------------+
    |   DISCLAIMER - LEGAL NOTICE -                                                              |
    +--------------------------------------------------------------------------------------------+
    |                                                                                            |
    |  This program is free for non comercial use, see the license terms available at            |
    |  http://www.francodacosta.com/licencing/ for more information                              |
    |                                                                                            |
    |  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; |
    |  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. |
    |                                                                                            |
    |  USE IT AT YOUR OWN RISK                                                                   |
    |                                                                                            |
    |                                                                                            |
    +--------------------------------------------------------------------------------------------+

*/
/**
 * phMagick - get image info
 *
 * @package    phMagick
 * @version    0.1.0
 * @author     Nuno Costa - sven@francodacosta.com
 * @copyright  Copyright (c) 2007
 * @license    http://www.francodacosta.com/phmagick/license/
 * @link       http://www.francodacosta.com/phmagick
 * @since      2008-03-13
 */

 //Samson Modified

class phMagick_info{


	function getInfo(phmagick $p, $file=''){
		if ($file == '') $file = $p->getSource();


		//Samson Modify
		//return getimagesize  ($file);

        $cmd = $p->getBinary('identify');
		$cmd .= ' -format "%w|%h|%z" ';
        $cmd .= ' "' . $p->getSource() .'" ';

        //$ret = $p->execute($cmd);
        $p->setHistory($p->getDestination());


		$shellCmd = escapeshellcmd( $cmd );
		$ret = exec( $shellCmd, $out );

		//$ret = $p->execute( $cmd );

		//file_put_contents( '/var/www/html/resize-log.txt', $ret ."\n" , FILE_APPEND );

		return explode('|', $ret);

	}

	function getWidth(phmagick $p, $file=''){
		$temp_res = $this->getInfo($p, $file);
		list($width, $height, $bits) = $temp_res;
		$width = (int) $width;
		$height = (int) $height;
		$bits = (int) $bits;
		return $width;
	}

	function getHeight(phmagick $p, $file=''){
		$temp_res = $this->getInfo($p, $file);
		list($width, $height, $bits) = $temp_res;
		$width = (int) $width;
		$height = (int) $height;
		$bits = (int) $bits;
	   return $height;
	}


	function getBits(phmagick $p, $file=''){
		$temp_res = $this->getInfo($p, $file);
		list($width, $height, $bits) = $temp_res;
		$width = (int) $width;
		$height = (int) $height;
		$bits = (int) $bits;
	   return $bits;
	}

	function getMime(phmagick $p, $file=''){
		if ($file == '') $file = $p->getSource();
       $info =  getimagesize  ($file);
       return $info["mime"];
	}
}
?>