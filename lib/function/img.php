<?php
function img($src, $width = '', $height = ''){	
	$src = rawurldecode($src);
	$ori = $src;
	$rootPath = dirname(__FILE__);
	$rootPath = str_replace('\\', '/', $rootPath);
	$rootPath = explode('/', $rootPath);
	array_pop($rootPath);
	array_pop($rootPath);
	$rootPath = implode('/', $rootPath) . '/';
	$no_image = "assets/images/no_image.png";
		
	if(!file_exists($rootPath . $src) || !preg_match('/./', $src)) $src = $no_image;	
		
	$info = getimagesize($rootPath . $src);
	if(empty($width) && empty($height)){
		$width = $info[0];
		$height = $info[1];
	}

	if(!empty($width) && empty($height)){
		if($width < $info[0]){
			$aspect = $info[0] / $info[1];
			$height = $width / $aspect;
		}else{
			$width = $info[0];
			$height = $info[1];
		}
	}
	
	if(empty($width) && !empty($height)){
		if($height < $info[1]){
			$aspect = $info[1] / $info[0];
			$width = $aspect / $width;
		}else{
			$width = $info[0];
			$height = $info[1];
		}
	}
			
	$filename = basename($src);
	$original = explode('.', $filename);
	$extension = array_pop($original);
	$tmpPath = 'cache/';
		
	if(!file_exists($rootPath . $tmpPath)) {
		createPath($rootPath . $tmpPath);
	}
	
	$tmpFile = md5($src) . '_' . $width . 'x' . $height . '.' . $extension;
	$tmpSrc = $tmpPath . $tmpFile;
			
	if(!file_exists($rootPath . $tmpSrc)) {
		if(!empty($src)){
			$image = new Image($rootPath . $src);
			$image->resize($width, $height, "");
			$image->save($rootPath . $tmpSrc);
		}
	}
		
	return 'http://' . $_SERVER['HTTP_HOST'] . option('site_uri') . $tmpSrc;
}

function imgCrop($src, $width = '', $height = ''){	
	$src = rawurldecode($src);
	$ori = $src;
	$rootPath = dirname(__FILE__);
	$rootPath = str_replace('\\', '/', $rootPath);
	$rootPath = explode('/', $rootPath);
	array_pop($rootPath);
	array_pop($rootPath);
	$rootPath = implode('/', $rootPath) . '/';
	$no_image = "assets/images/no_image.png";
		
	if(!file_exists($src)) $src = $no_image;
	
	$info = getimagesize($rootPath . $src);
	if(empty($width) && empty($height)){
		$width = $info[0];
		$height = $info[1];
	}

	if(!empty($width) && empty($height)){
		if($width < $info[0]){
			$aspect = $info[0] / $info[1];
			$height = $width / $aspect;
		}else{
			$width = $info[0];
			$height = $info[1];
		}
	}
	
	if(empty($width) && !empty($height)){
		if($height < $info[1]){
			$aspect = $info[1] / $info[0];
			$width = $aspect / $width;
		}else{
			$width = $info[0];
			$height = $info[1];
		}
	}
	
	$filename = basename($src);
	$original = explode('.', $filename);
	$extension = array_pop($original);
	$tmpPath = 'cache/';
	
	if(!file_exists($rootPath . $tmpPath)) {
		createPath($rootPath . $tmpPath);
	}
	
	$tmpFile = md5($src) . '_' . $width . 'x' . $height . '_cropped.' . $extension;
	$tmpSrc = $tmpPath . $tmpFile;
		
	if(!file_exists($rootPath . $tmpSrc)) {
		if(!empty($src)){
			$image = new Image($rootPath . $src);
			$image->cropsize($width, $height);
			$image->save($rootPath . $tmpSrc);
		}
	}
	return 'http://' . $_SERVER['HTTP_HOST'] . option('site_uri') . $tmpSrc;
}

function rotate($src){	
	$return['error'] = true;
	$return['msg'] = 'File not found.';
		
	$src = rawurldecode($src);
	$ori = $src;
	$rootPath = dirname(__FILE__);
	$rootPath = str_replace('\\', '/', $rootPath);
	$rootPath = explode('/', $rootPath);
	array_pop($rootPath);
	array_pop($rootPath);
	$rootPath = implode('/', $rootPath) . '/';
	$no_image = "assets/images/thumb_defaultImage.jpg";
		
	if(file_exists($src)){
		$filename = basename($src);
		$original = explode('.', $filename);
		$extension = array_pop($original);		
		
		$path = explode('/', $src);
		array_pop($path);
		$path = implode('/', $path) . '/';
		
		$tmpFile = current($original) . '_' . time() . '.' . $extension;
		$tmpSrc = $path . $tmpFile;
					
		if(!file_exists($rootPath . $tmpSrc)) {
			if(!empty($src)){
				$image = new Image($rootPath . $src);
				$image->rotate(90, 0);
				$image->save($rootPath . $tmpSrc);
				array_map('unlink', glob($rootPath . $src));
				clearCache();
			}
		}
		
		$return['error'] = false;
		$return['msg'] = 'File rotated.';
		$return['src'] = $tmpSrc;
	}
	
	return $return;
}

function cropResize($oriW, $oriH, $width, $height){
	if($oriW != $oriH){
		if($width < $oriW || $height < $oriH){
			if($oriW > $oriH){
				$wScale = $oriW / $width;
				$height = round($oriH / $wScale);
			}else{
				$hScale = $oriH / $height;
				$width = round($oriW / $hScale);
			}
		}else{
			$width = $oriW;
			$height = $oriH;
		}
	}else{
		$width = $width;
		$height = $width;
	}
		
	$size['w'] = $width;
	$size['h'] = $height;
	
	return $size;
}

function clearCache(){	
	$rootPath = dirname(__FILE__);
	$rootPath = str_replace('\\', '/', $rootPath);
	$rootPath = explode('/', $rootPath);
	array_pop($rootPath);
	array_pop($rootPath);
	$rootPath = implode('/', $rootPath) . '/';
	
	array_map('unlink', glob($rootPath . "/cache/*.*"));
	array_map('unlink', glob($rootPath . "/backpanel/cache/*.*"));
	
	return $rootPath;
}

function createPath($path) {
	if(is_dir($path)) return true;
	$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
	$return = createPath($prev_path);
	return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

function dirSize($directory) {
	if(!file_exists($directory)) {
		createPath($directory);
	}
	
	$size = 0;
	foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
		$size+=$file->getSize();
	}
	return $size;
}
?>