<?php

class ImageManipulation_model {

	var $imgOrig = null;
	var $imgFinal = null;
	
	function loadResizeCropSave($filenameSource, $filenameDest, $nx, $ny, $fixOrientacao = false, $sox = false, $soy = false) {
		if ($this->loadImage($filenameSource)) {
		    $this->resize($nx,$ny, true, $fixOrientacao, true);
		    $this->crop($nx,$ny,false,$fixOrientacao,$sox,$soy);
		    $this->saveImage($filenameDest);
		    $this->flushImages();
		}
	}
	function loadResizeSave($filenameSource, $filenameDest, $nx, $ny, $fixOrientacao = true) {
		if ($this->loadImage($filenameSource)) {
		    $this->resize($nx,$ny, true, $fixOrientacao);
		    $this->saveImage($filenameDest);
		    $this->flushImages();
		}
	}

	function loadSave($filenameSource, $filenameDest, $quality=90) {
		if ($this->loadImage($filenameSource)) {
		    $this->imgFinal = $this->imgOrig;
			$this->saveImage($filenameDest, $quality);
		    $this->flushImages();
		}
	}
	
	function loadCropSave($filenameSource, $filenameDest, $nx, $ny, $sox = false, $soy = false) {
		if ($this->loadImage($filenameSource)) {
		    $this->crop($nx,$ny,false,false,$sox,$soy);
		    $this->saveImage($filenameDest);
		    $this->flushImages();
		}
	}
	
	function loadCropResizeSave($filenameSource, $filenameDest, $x, $y, $w, $h, $nw, $nh) {
		if ($this->loadImage($filenameSource)) {
			$this->cropResize($x, $y, $w, $h, $nw, $nh);
			$this->saveImage($filenameDest);
			$this->flushImages();
		}
	}
	
	function loadImage($filename)
	{
		$this->imgOrig = @imagecreatefromjpeg($filename);
		if ($this->imgOrig == null) {
			return false;
		}
		return true;
	}
	function saveImage($filename, $quality = 90) {
		return imagejpeg($this->imgFinal, $filename, $quality);
	}
	
	function getWidth(){
		return imagesx($this->imgOrig);
	}
	
	function getHeight(){
		return imagesy($this->imgOrig);
	}
	
	function flushImages($original = true)
	{
		@imagedestroy($this->imgFinal);
		$this->imgFinal = null;
		if ($original) {
			@imagedestroy($this->imgOrig);
			$this->imgOrig = null;
		}
	}
	
	function crop($nx, $ny, $changeOrig = false, $fixOrientacao = false, $sox = false, $soy = false)
	{
		$ox = imagesx($this->imgOrig);
		$oy = imagesy($this->imgOrig);

		if($fixOrientacao && (($ox < $oy && $nx > $ny) || ($ox > $oy && $nx < $ny))) {
			$nnx = $ny;
			$nny = $nx;
			$ny = $nny;
			$nx = $nnx;
		}
		
		if ($sox===false || $soy===false){
			list($sox, $soy) = array(ceil(($ox-$nx)/2) > 0 ? ceil(($ox-$nx)/2) : 0, ceil(($oy-$ny)/2) > 0 ? ceil(($oy-$ny)/2) : 0);
		}
		
		$this->imgFinal = imagecreatetruecolor($nx, $ny);
		imagecopyresampled($this->imgFinal, $this->imgOrig, 0, 0, $sox, $soy, $nx, $ny, $nx, $ny);

		if ($changeOrig)
			$this->imgOrig = $this->imgFinal;
		
		return true;
	}
	
	function cropResize($x, $y, $w, $h, $nw, $nh)
	{
		$this->imgFinal = imagecreatetruecolor($nw, $nh);
		imagecopyresampled($this->imgFinal, $this->imgOrig, 0, 0, $x, $y, $nw, $nh, $w, $h);
		
		return true;
	}
	
	function resize($nx, $ny, $changeOrig = false, $fixOrientacao = true, $for_crop=false) {
		$ox = imagesx($this->imgOrig);
		$oy = imagesy($this->imgOrig);
		
		if ($fixOrientacao && (($ox > $oy && $nx < $ny) || ($oy > $ox && $ny < $nx))) {
			$nnx = $ny;
			$nny = $nx;
			$nx = $nnx;
			$ny = $nny;
		}
		
		
		$nx2 = ($ox * $ny) / $oy;
		$ny2 = ($oy * $nx) / $ox;

		if ($for_crop) {
			if ($nx2 < $nx) {
				$nx2 = ($ox * $ny2) / $oy;
			}
			if ($ny2 < $ny) {
				$ny2 = ($oy * $nx2) / $ox;
			}
		} else {
			if ($nx2 > $nx) {
				$nx2 = $nx;
				$ny2 = ($oy * $nx2) / $ox;
			}
			if ($ny2 > $ny) {
				$ny2 = $ny;
				$nx2 = ($ox * $ny2) / $oy;
			}
		}

		$nx = $nx2;
		$ny = $ny2;
			
		$this->imgFinal = imagecreatetruecolor($nx, $ny);
		imagecopyresampled($this->imgFinal, $this->imgOrig, 0, 0, 0, 0, $nx, $ny, $ox, $oy);
		
		if ($changeOrig)
			$this->imgOrig = $this->imgFinal;
			
		return true;
	}
}
?>