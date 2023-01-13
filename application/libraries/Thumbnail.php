<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Thumbnail Library
 * @author Skyler Richter
 */
class Thumbnail
{
	//Codeignter base object.
	private $ci;
	
	/**
	 * Construct the thumbnail class
	 * Bring the CI object into scope
	 */	
	public function __construct()
	{
		//Get an instance of the CI base object.
		$this->ci =& get_instance();
	}
	
	/**
	 * Generate thumbnails on the fly.
	 * @param $image string
	 * @param $width integer
	 * @param $height integer
	 * @return string
	 */
	public function generate($arguments = array())
	{
		extract(filter_options(array('image', 'width', 'height', 'crop', 'respect', 'crop_from_top', 'force_enlarge', 'sitepath'), $arguments));
		
		//Extract the file name.
		$image_name = array_pop(explode('/', $image));
		
		//Extract the file path.
		$image_path = str_replace($image_name, '', $image);

		if($sitepath === false)
		{
			$sitepath = SITEPATH;
		}

		//Set the system path.
		$system_path = preg_replace('/\/$/', '', $sitepath) . $image_path;

		//Load the file helper to check for SVGs
		$this->ci->load->helper('file');

		//Set the name of the thumb folder
		$thumb_folder = array_shift(explode('.', $image_name)) . '/';

		//Set the path of the thumbnails
		$thumb_path = $system_path . $thumb_folder;

		//Generate a file name for the thumbnail.
		$thumbnail_short_name = (($width !== false) ? $width . 'w_' : '') . (($height !== false) ? $height . 'h_' : '') . $image_name;

		//Search the thumb folder for this file for any matching the "short name" (so excluding the timestamp)
		//The hyphen needs to be there too to prevent it from finding the old thumbnails that don't have the timestamp
		$thumb_search = glob($thumb_path . '*-' . $thumbnail_short_name);

		//If we found a thumbnail file that matches, set the thumbnail var to that filename, but strip out the path
		if(!empty($thumb_search))
		{
			$thumbnail = str_replace($thumb_path, '', $thumb_search[0]);

			return $image_path . $thumb_folder . $thumbnail;
		}
		else
		{
			//Prepend timestamp to filename to make sure browser doesn't cache the file
			$thumbnail = time() . '-' . $thumbnail_short_name;
		}
		

		$this->ci->load->library('file_manipulation');
	
		$this->ci->file_manipulation->resize($image_name, $system_path, true);


		//Does no thumbnail exist already?
		if(empty($thumb_search))
		{
			//Does the original file exist?
			if(file_exists($system_path . $image_name))
			{
				
				if(!is_dir($thumb_path)){
				
					mkdir($thumb_path);
					chmod($thumb_path, 0777);
				}
			
				//Get the dimensions of the original image.
				$image_dimensions = getimagesize($system_path . $image_name);

				//What will the width of the new image be?
				$new_width = $height !== false ? ceil($image_dimensions[0] * $height / $image_dimensions[1]) : false;

				//What will the height of the new image be?
				$new_height = $width !== false ? ceil($image_dimensions[1] * $width / $image_dimensions[0]) : false;

				//Determine the resize ratio.
				$resize_ratio = (($image_dimensions[1] / $image_dimensions[0]) - (($height !== false ? $height : $new_height) / ($width !== false ? $width : $new_width)));

				//Can the image be resized?
				if(($width === false && $new_width < $image_dimensions[0] && $height < $image_dimensions[1]) || ($height === false && $width < $image_dimensions[0] && $new_height < $image_dimensions[1]) || ($width <= $image_dimensions[0] && $height <= $image_dimensions[1]) || ($width >= $image_dimensions[0] && $height <= $image_dimensions[1]) || ($height >= $image_dimensions[1] && $width <= $image_dimensions[0]) || ($force_enlarge == true))
				{
					//Load the image manipulation library.
					$this->ci->load->library('image_lib');
					
					//Does the image need to be cropped?
					if($crop !== false)
					{
						if($respect === false)
						{
							//Get the original image type
							if($image_dimensions[0] == $image_dimensions[1])
							{
								//Original image is a boring old sqaure.
								$original_dim = 'square';
							}
							else
							{
								//Original image is a rectangle of epic proportions.
								$original_dim = $image_dimensions[0] > $image_dimensions[1] ? 'landscape' : 'portrait';
							}
							
							//Get the thumb image type
							if($width == $height)
							{
								//Congratulations, It's a baby square!
								$thumb_dim = 'square';
							}
							else
							{
								//Congratulations, It's a baby rectangle!
								$thumb_dim = $width > $height ? 'landscape' : 'portrait';
							}
							
							if($original_dim === $thumb_dim)
							{
								//$resize_config['master_dim'] = $thumb_dim === 'landscape' ? 'width' : 'height';
								
								// ar - aspect ratio
								$orig_ar = round($image_dimensions[0] / $image_dimensions[1], 2);
								$thumb_ar = round($width / $height, 2);
								
								if($orig_ar > $thumb_ar) 
								{
									$resize_config['master_dim'] = 'height';
								}
								else
								{
									$resize_config['master_dim'] = 'width';
								}
							}
							else
							{
								if($original_dim === 'square')
								{
									$resize_config['master_dim'] = $thumb_dim === 'landscape' ? 'width' : 'height';
								}
								elseif($original_dim === 'landscape')
								{
									$resize_config['master_dim'] = 'height';
								}
								elseif($original_dim === 'portrait')
								{
									$resize_config['master_dim'] = 'width';
								}
							}
						}
						else
						{
							$resize_config['master_dim'] = $respect;
						}
						
						$resize_config['height'] = $height;

						$resize_config['width'] = $width;
						
						$resize_config['maintain_ratio'] = true;
						
						//Set the source path to the original image.
						$resize_config['source_image'] = $system_path . $image_name;

						//Set the path to the new image.
						$resize_config['new_image'] = $thumb_path . $thumbnail;

						//Use the image magick library to manipulate images.
						$resize_config['image_library'] = 'imagemagick';

						//Server path to image magick.
						$resize_config['library_path'] = '/usr/bin';
						
						// If one dimension size is smaller than it's thumb size, don't resize
						if(!(($width > $image_dimensions[0]) || ($height > $image_dimensions[1])) || ($force_enlarge == true) )
						{
							//Load the image manipulation class and initialize settings.
							$this->ci->image_lib->initialize($resize_config); 
	
							//Resize, generate the pre-thumbnail image.
							$this->ci->image_lib->resize();
													
							//Reset the image_lib settings.
							$this->ci->image_lib->clear();
						}

					
						//RESIZE ENDS HERE!!!

						unset($image_dimensions, $resize_config);
						
						//Check if a thumbnail image was created and exists in the thumb folder
						$file_exists = file_exists($thumb_path . $thumbnail);
						
						//If no thumbnail exists in thumb folder, copy original there to be cropped
						if($file_exists == false)
						{
							copy($system_path . $image_name, $thumb_path . $thumbnail);
						}

						$image_dimensions = getimagesize($thumb_path . $thumbnail);
																								
						$crop_config['height'] = $height;

						$crop_config['width'] = $width;
				
						if($image_dimensions[0] > $width)
						{
							//Set the x-axis (left) cropping offset.
							$crop_config['x_axis'] = (($image_dimensions[0] - $width) / 2);
						}

						if($image_dimensions[1] > $height)
						{
							if($crop_from_top === true)
							{
								//Set the y-axis (top)
								$crop_config['y_axis'] = (0);
							}
							else
							{
								//Set the y-axis (top) cropping offset. (center)
								$crop_config['y_axis'] = (($image_dimensions[1] - $height) / 2);
							}
						}
						
						//Don't maintain the aspect ration of the image.
						$crop_config['maintain_ratio'] = false;
						
						//Set the source path to the original image.
						$crop_config['source_image'] = $thumb_path . $thumbnail;
						
						//Use the image magick library to manipulate images.
						$crop_config['image_library'] = 'imagemagick';
						
						//Server path to image magick.
						$crop_config['library_path'] = '/usr/bin';
						
						//Initialize the crop settings.
						$this->ci->image_lib->initialize($crop_config);
												
						//Crop the image.
						$this->ci->image_lib->crop();
						
						//Reset the image_lib settings.
						$this->ci->image_lib->clear();
					
						unset($image_dimensions, $crop_config);
					}
					else
					{
						//Is there a width set?
						if($width !== false)
						{
							//Set the resize width.
							$resize_config['width'] = $width;
						}
						
						//Is there a height set?
						if($height !== false)
						{
							//Set the resize height.
							$resize_config['height'] = $height;
						}
						
						//Are both width and height set? Are the the same?
						if(($width !== false) && ($height !== false) && ($width !== $height))
						{
							//Don't maintain the aspect ratio.
							$resize_config['maintain_ratio'] = false;
						}
												
						//Set the source path to the original image.
						$resize_config['source_image'] = $system_path . $image_name;
						
						//Set the path to the new image.
						$resize_config['new_image'] = $thumb_path . $thumbnail;
						
						//Use the image magick library to manipulate images.
						$resize_config['image_library'] = 'imagemagick';
						
						//Server path to image magick.
						$resize_config['library_path'] = '/usr/bin';

						//Load the image manipulation class and initialize settings.
						$this->ci->image_lib->initialize($resize_config); 

						//Resize, generate the pre-thumbnail image.
						$this->ci->image_lib->resize();

						//Unset the resize_config array.
						unset($image_dimensions, $resize_config);

						//Reset the image_lib settings.
						$this->ci->image_lib->clear();
						
						//mkdir($system_path . "test" . $thumbnail);
					}
													
					//The force is strong with this one...
					return $image_path . $thumb_folder . $thumbnail;
				}				
				
				//Unable to crop given dimensions.
				return $image_path . $image_name;
			}

			//Could not find the original image to resize.
			return false;
		}
		
		//Thumbnail already exists.
		return $image_path . $thumb_folder . $thumbnail;
	}
	
}