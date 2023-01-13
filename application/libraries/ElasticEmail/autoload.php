<?php
spl_autoload_register(
    function ($className) 
    {
      if (strpos($className, 'ElasticEmail') !== 0) return;

      $filePath = dirname(__FILE__) . '/' . 'ElasticEmailClient.php';

      if (file_exists($filePath)) require_once($filePath);
    }
);