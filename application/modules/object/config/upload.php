<?php

// Upload file
$config['upload'] = array(
    'options' => array(
        'upload_path'   => 'asset/img/object',
        'allowed_types' => 'jpg|jpeg|png|gif',
        'max_size'      => '2000',
        'max_width'     => 0,
        'max_height'    => 0,  
    ),
    'image_lib' => array(
        'image_library'  => 'gd2',
        'quality'        => '85%',
        'maintain_ratio' => TRUE,
    )
);
