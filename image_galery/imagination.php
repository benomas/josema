<?php
class Imagination
{
	private $imgSizes;
	private $imgExtensions;
	private $imgExtensionForSave;
	private $imgFiles;
	private $dirFiles;
	private $defaultSize;
	private $image;
	private $width;
	private $height;
	private $imageResized;



    // constructor
    function Imagination($options=array())
	{
		$this->defaultSize='original';
		$this->imgSizes	=	array	(	'original'		=>array(	'width'		=>'100%',
																	'height'	=>'100%',
																	'quality'	=>'100',
																	'option'	=>'exact',
																	'alias'		=>'',
																	'path'		=>''
																)
									);
		$this->imgExtensions=array('jpg','jpeg','png','gif');
		$this->imgExtensionForSave='.jpg';
		$this->imgFiles=array();
		$this->setConfig($options);
		$this->scanDir();
    }

	function setConfig( $options = array() )
	{
		foreach($options as $option => $value)
		{
			$this->$option = $value;
		}
	}

	function scanDir($size='',$withPath=FALSE)
	{
		if(empty($size))
			$size=$this->defaultSize;
		$scaned=scandir ( $this->imgSizes[$size]['path']);

					//debugg($scaned);die();
		foreach($scaned AS $value)
		{
			if(is_file($this->imgSizes[$size]['path'].$value))
			{
				foreach($this->imgExtensions AS $extension)
				{
					$search = preg_quote($extension);
					$search= '/\.'.$search.'$/';
					if(preg_match($search,$value))
					{
						if($withPath)
							$this->imgFiles[$size][]=$this->imgSizes[$size]['path'].$value;
						else
							$this->imgFiles[$size][]=$value;
					}
				}

			}

		}
	}

	function resetImgFiles()
	{
		$this->imgFiles=array();
	}

	function makeSubImagination($size='')
	{
		if(!empty($size))
		{
			if($size!=$this->defaultSize)
			{
				$imgSize=$this->imgSizes[$size];

				if ($this->makeDir($imgSize['path']))
				{
					foreach($this->imgFiles[$this->defaultSize] AS $imgFile)
					{
						if(!is_file($this->newFileName($imgFile,$imgSize)))
						{
							$this->image = $this->openImage($this->imgSizes[$this->defaultSize]['path'].$imgFile);
							$this->width  = imagesx($this->image);
							$this->height = imagesy($this->image);
							$this->resizeImage($imgSize);
							$this->saveImage($imgSize,$imgFile);
						}
					}
				}
			}
		}
		else
		{
			foreach($this->imgSizes AS $imgSize=>$size)
			{
				$this->makeSubImagination($imgSize);
			}
		}
	}

	function makeDir($dirName='')
	{
		if(!empty($dirName))
		{
			if (!is_dir($dirName))
			{
				return mkdir($dirName);
			}
			return true;
		}
		return false;
	}

	function getImgFiles($size='')
	{
		if(empty($size))
		{
			foreach($this->imgSizes AS $imgSize=>$sizes)
			{
				$this->getImgFiles($imgSize);
			}
		}
		else
		{
			$this->scanDir($size);
		}
		return $this->imgFiles;
	}

	function getImgPathFiles($size='')
	{
		if(empty($size))
		{
			foreach($this->imgSizes AS $imgSize=>$sizes)
			{
				$this->getImgPathFiles($imgSize);
			}
		}
		else
		{
			$this->scanDir($size,TRUE);
		}
		return $this->imgFiles;
	}


	private function openImage($fileName)
	{
		//$fileName = preg_quote($file);

		$search= '/(.+)?\.([0-9a-zA-Z]+)$/';
		$extension =  preg_replace($search,'.${2}',$fileName);
		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($fileName);
				break;
			case '.gif':
				$img = @imagecreatefromgif($fileName);
				break;
			case '.png':
				$img = @imagecreatefrompng($fileName);
				break;
			default:
				$img = false;
				break;
		}
		return $img;
	}

	public function resizeImage($imgSize)
	{
		// *** Get optimal width and height - based on $option
		$optionArray = $this->getDimensions($imgSize['width'], $imgSize['height'], $imgSize['option']);
		$optimalWidth  = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];


		// *** Resample - create image canvas of x, y size

		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagealphablending($this->imageResized, false);
		imagesavealpha($this->imageResized,true);
		$transparent = imagecolorallocatealpha($this->imageResized, 255, 255, 255, 127);
		$w=$optimalWidth;
		$h=$optimalHeight;
		imagefilledrectangle($this->imageResized, 0, 0, $w, $h, $transparent);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);


		// *** if option is 'crop', then crop too
		if ($imgSize['option'] == 'crop')
		{
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}
	}

	private function getDimensions($newWidth, $newHeight, $option)
	{
		switch ($option)
		{
			case 'original':
							$optimalWidth = $this->width;
							$optimalHeight= $this->height;
							break;
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}


	private function getSizeByFixedHeight($newHeight)
	{
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth)
	{
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	private function getSizeByAuto($newWidth, $newHeight)
	{

		if ($this->height < $this->width)
		// *** Image to be resized is wider (landscape)
		{
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		elseif ($this->height > $this->width)
		// *** Image to be resized is taller (portrait)
		{
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		else
		// *** Image to be resizerd is a square
		{
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				// *** Sqaure being resized to a square
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}
	private function getOptimalCrop($newWidth, $newHeight)
	{

		$heightRatio = $this->height / $newHeight;
		$widthRatio  = $this->width /  $newWidth;

		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}

		$optimalHeight = $this->height / $optimalRatio;
		$optimalWidth  = $this->width  / $optimalRatio;

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
	{
		// *** Find center - this will be used for the crop
		$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
		$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

		$crop = $this->imageResized;
		//imagedestroy($this->imageResized);

		// *** Now crop from center to exact requested size
		$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
		imagealphablending($this->imageResized, false);
		imagesavealpha($this->imageResized,true);
		$transparent = imagecolorallocatealpha($this->imageResized, 255, 255, 255, 127);
		imagefilledrectangle($this->imageResized, 0, 0, $w, $h, $transparent);
		imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
	}

	public function saveImage($imgSize,$imgFile)
	{
		$search= '/(.+)?\.([0-9a-zA-Z]+)$/';
		$extension 	= 	preg_replace($search,'.${2}',$imgFile);
		$fileName	=	preg_replace($search,'${1}',$imgFile);
		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG)
				{
					if(isset($this->imgExtensionForSave) && $this->imgExtensionForSave==='.jpg')
						imagejpeg($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$this->imgExtensionForSave, $imgSize['quality']);
					else
						imagejpeg($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$extension, $imgSize['quality']);
				}
				break;

			case '.gif':
				if (imagetypes() & IMG_GIF)
				{
					if(isset($this->imgExtensionForSave) && $this->imgExtensionForSave==='.jpg')
						imagejpeg($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$this->imgExtensionForSave, $imgSize['quality']);
					else
						imagegif($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$extension);
				}
				break;

			case '.png':
				// *** Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imgSize['quality']/100) * 9);

				// *** Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9 - $scaleQuality;

				if (imagetypes() & IMG_PNG)
				{
					if(isset($this->imgExtensionForSave) && $this->imgExtensionForSave==='.jpg')
						imagejpeg($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$this->imgExtensionForSave, $imgSize['quality']);
					else
						imagepng($this->imageResized, $imgSize['path'].$fileName.$imgSize['alias'].$extension, $invertScaleQuality);
				}
				break;

			// ... etc

			default:
				// *** No extension - No save.
				break;
		}

		imagedestroy($this->imageResized);
	}

	function newFileName($originalName,$imgSize)
	{
		$search= '/(.+)?\.([0-9a-zA-Z]+)$/';
		$extension 	= 	preg_replace($search,'.${2}',$originalName);
		$fileName	=	preg_replace($search,'${1}',$originalName);

		return $imgSize['path'].$fileName.'_'.$imgSize['alias'].$extension;
	}
}
?>