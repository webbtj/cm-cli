<?php

class CM_CLI_Chunker{

    public function __construct(){
        $this->chunkables = [];
    }

    public function register_chunkable($file_name, $chunkable_key, $chunk_file){
        if(!isset($this->chunkables[$file_name])){
            $this->chunkables[$file_name] = array();
        }
        $this->chunkables[$file_name][] = array('key' => $chunkable_key, 'file' => $chunk_file);
    }

    public function chunk($source_file, $source_content){
        $basename = basename($source_file);

        if($this->is_chunkable($source_file)){
            foreach($this->chunkables[$basename] as $chunker){
                $chunk_content = $chunker['key'] . "\n" . rtrim(file_get_contents(dirname(dirname(__FILE__)) . '/' . $chunker['file']));
                $chunk_content = $this->replacer($chunk_content);
                $source_content = str_replace($chunker['key'], $chunk_content, $source_content);
            }
        }
        return $source_content;
    }

    public function is_chunkable($source_file){
        return array_key_exists(basename($source_file), $this->chunkables);
    }

    public function replacer($contents){
        global $theme_title;
        global $taxonomy_slug;
        global $taxonomy_label;
        global $post_type;
        global $post_name;
        global $index_page;
        global $menu_slug;
        global $menu_name;
        global $image_size_slug;
        global $image_size_width;
        global $image_size_height;
        global $image_size_crop;
        global $custom_page_template_name;
        global $custom_page_template_label;
        $replace = array(
            '[[theme-title]]' => $theme_title,
            '[[taxonomy-slug]]' => $taxonomy_slug,
            '[[taxonomy-label]]' => $taxonomy_label,
            '[[post-type]]' => $post_type,
            '[[post-name]]' => $post_name,
            '[[index-page]]' => $index_page,
            '[[menu-slug]]' => $menu_slug,
            '[[menu-name]]' => $menu_name,
            '[[image-size-slug]]' => $image_size_slug,
            '[[image-size-width]]' => $image_size_width,
            '[[image-size-height]]' => $image_size_height,
            '[[image-size-crop]]' => $image_size_crop,
            '[[custom-page-template-name]]' => $custom_page_template_name,
            '[[custom-page-template-label]]' => $custom_page_template_label,
        );

        foreach($replace as $key => $value){
            $contents = str_replace($key, $value, $contents);
        }

        return $contents;
    }
}
