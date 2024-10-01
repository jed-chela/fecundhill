<?php

class Photos extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function _create_thumbnail($fileName, $width = 100, $height = 100)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $_SERVER['DOCUMENT_ROOT'] . $fileName;
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $_SERVER['DOCUMENT_ROOT'] . $fileName;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
}

?>