<?php

class CM_CLI_ImageSize{
	/**
	 * Register a custom image size in your C+M Smarty theme
	 *
	 * ## OPTIONS
	 *
     * <width>
	 * : The width
	 *
     * [--height=<height>]
     * : The height
     * ---
     * default: 0
     *
     * [--scale]
     * : Use this to scale instead of crop, crop is the default
     *
	 * ## EXAMPLES
	 *
	 *     wp cm create-menu main "Main Menu"
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

		global $chunker;

        $width = max(0, (int) $args[0]);
        $height = max(0, (int) $assoc_args['height']);
        $crop = var_export(!(bool) isset($assoc_args['scale']), true);

        if($width && $height){
            $slug = $width."x".$height;
        }elseif($width){
            $slug = $width."w";
        }elseif($height){
            $slug = $height."h";
        }else{
            WP_CLI::error( "Cannot create a 0x0 image size" );
        }

		global $image_size_slug;
        global $image_size_width;
        global $image_size_height;
        global $image_size_crop;

		$image_size_slug = $slug;
		$image_size_width = $width;
		$image_size_height = $height;
		$image_size_crop = $crop;

        $this->register_chunkables();

        if(CM_CLI_Helper::active_theme_dir()){
            $destination = CM_CLI_Helper::active_theme_dir();
            $file = "$destination/includes/custom-image-sizes.php";
            $content = $chunker->chunk($file, file_get_contents($file));
            file_put_contents($file, $content);

            WP_CLI::success( "Custom Image Size $slug was created..." );
            WP_CLI::success( CM_CLI_Helper::reward() );
        }
	}

	public function register_chunkables(){
		global $chunker;

		$chunker->register_chunkable('custom-image-sizes.php', '//--Image Sizes',
            'chunks/includes/custom-image-sizes/_image_sizes');
	}

}
WP_CLI::add_command( 'cm create-image-size', 'CM_CLI_ImageSize');
