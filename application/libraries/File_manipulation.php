<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File_manipulation
{
	private $ci;

	private $max_size = 2000;
	
	public function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->library('image_lib');

		$this->ci->load->helper(array('url','file'));
	}

	public function rotate($image, $angle)
	{
		//If the file is an SVG, don't rotate it, it doesn't work, and will break the image. One day we will make it work though.
		//We should also disable or hide the rotate button for SVGs, but this is a failsafe

		$config['image_library'] = 'imagemagick';
		$config['library_path'] = '/usr/bin';
		$config['source_image']	= $image;
		$config['rotation_angle'] = $angle;

		$this->ci->image_lib->initialize($config); 

		if ( ! $this->ci->image_lib->rotate())
		{
		    return false;
		}
		else
		{
			return $image;
		}
	}

	public function resize($image, $path, $existing = false) //image should be the uploaded file
	{
		if($existing == true)
		{
			$image_file = $image;
			$image_size = getimagesize($path . '/' . $image_file);
			$image_width = $image_size[0];
			$image_height = $image_size[1];
		}
		else
		{
			$image_file = $image['file_name'];
			$image_width = $image['image_width'];
			$image_height = $image['image_height'];
		}

		if( $image_width > $this->max_size || $image_height > $this->max_size)
		{
			if($image_width > $image_height)
			{
				$image_config['width'] = $this->max_size;

				$image_config['height'] = '';
						
			}
			elseif($image_width < $image_height)
			{
				$image_config['width'] = '';

				$image_config['height'] = $this->max_size;
			}

			$image_config['image_library'] = 'imagemagick';

			$image_config['library_path'] = '/usr/bin';

			$image_config['source_image'] = $path . $image_file;
										
			$this->ci->image_lib->initialize($image_config); 
										
			if ( ! $this->ci->image_lib->resize())
			{
			    return false;
			}
			else
			{
				return $image;
			}
		}
		else
		{
			return false;
		}
	}

	public function delete_thumbs($image_file, $file_path)
	{
		//Name of thumb folder
		$thumb_folder = array_shift(explode('.', $image_file));

		//If thumb folder exists, empty it and delete it
		if(is_dir($file_path . $thumb_folder) && !empty($thumb_folder)) 
		{
			//Loop through all files in thumb folder
			foreach(glob($file_path . $thumb_folder . '/*.*') as $v)
			{
				//Delete each file	
				unlink($v);
			}
			//Delete thumb folder
			rmdir($file_path . $thumb_folder);
			
			return true;
		}
		return false;
	}

	public function delete_image($image_file, $file_path)
	{
		//Delete original image
		unlink($file_path . $image_file);
		
		$this->delete_thumbs($image_file, $file_path);

		return $thumbs; //true or false
	}

	public function delete_file($file_name, $file_path)
	{
		if(file_exists($file_path . $file_name))
		{
			//Delete original file
			$deleted = unlink($file_path . $file_name);
			
			$thumbs = $this->delete_thumbs($file_name);
		}

		if($deleted)
		{
			return true;
		}
		else{
			return false;
		}
	}
	public function move_files($current_path, $files = array(), $dest_path, $move_folders = false)
	{	
		$current_path = rtrim($current_path,'/');
		$dest_path = rtrim($dest_path,'/');

		if(is_dir($current_path)) 
		{
			if(!is_dir($dest_path)) mkdir($dest_path, 0774, true);

			//Loop through all files in the folder
			foreach(glob($current_path . ($move_folders ? '/' : '/*.*')) as $v)
			{
				$file_name = str_replace($current_path, '', $v);

				if($files && count($files) > 0 && in_array(ltrim($file_name, '/'), $files))
				{
					rename($v, $dest_path . $file_name);
				}
			}
		}
	}

	//realized that delete_files exists as part of codeigniter
	/*public function empty_folder($folder_path, $delete_folder = false)
	{
		$folder_path = rtrim($folder_path,'/');

		if(is_dir($folder_path)) 
		{
			//Loop through all files in the folder
			foreach(glob($folder_path) as $v)
			{
				//if it's a directory, call this function again
				if(is_dir($v))
				{	
					$this->empty_folder($v, $delete_folder);
				}
				else //Delete the file
				{
					unlink($v);
				}
			}

			//Delete the folder
			if($delete_folder) rmdir($folder_path);
			
			return true;
		}
		return false;
	}*/

	public function size_to_output($size)
	{
		if($size > 1024)
		{
			$size = $size / 1024;

			$dir_measure = 'KB';

			if ($size > 1024)
			{
				$size = $size / 1024;

				$dir_measure = 'MB';

				if($size > 1024)
				{
					$size = $size / 1024;

					$dir_measure = 'GB';

					if($size > 1024)
					{
						$size = $size / 1024;

						$dir_measure = 'TB';
					}
				}
			}
		}
		else
		{
			$dir_measure = 'B';
		}
		$size = round($size, 2);

		return "$size $dir_measure";
	}
}