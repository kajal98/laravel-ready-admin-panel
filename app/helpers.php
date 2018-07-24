<?php

use PragmaRX\Countries\Package\Countries;

function upload_tmp_path($file) {
  return public_path() . "/tmp/$file";
}
function upload_tmp_url($file) {
  return asset("tmp/$file");
}
function upload_path($file, $model, $variation=false, $relative=null) {
  $use_aws = is_null($relative)? env('AWS_STATUS',false) : $relative;
  $folder = "/uploads/". ( empty($variation) || $variation =='original' ? $model : "{$model}-{$variation}" ); 

  if (!$use_aws && !is_array($variation) && !file_exists(public_path().$folder)) {
      umask(0);
      @mkdir(public_path().$folder, 0777, true);
    }
  $target_path = ($use_aws? "" : public_path()) ."$folder/$file";
  return $target_path;
}
function upload_url($file, $model, $variation=false)  {
  $use_aws = env('AWS_STATUS',false);
  $folder = "/uploads/". ( empty($variation)  || $variation =='original' ? $model : "{$model}-{$variation}" );
  if(!empty($file)) {
    if($use_aws)
      return env('AWS_S3_HOST')."$folder/$file";
    else
      return asset("$folder/$file");
  } 
  return false;
}
function upload_move($file,$model,$variation=false,$source=false) {
  $use_aws = env('AWS_STATUS',false);
  $source = $source ? $source : upload_tmp_path($file);
  $target = upload_path($file,$model,$variation);
  if($use_aws) {
      $s3 = AWS::createClient('s3');
      $s3->putObject(array(
            'Bucket'     => env('AWS_S3_BUCKET'),
            'Key'        => $target,
            'SourceFile' => $source,
            'ACL'    => 'public-read'
        ));
  } else {
     copy($source, $target);
  }
}

function upload_delete($file,$model,$variations=false) {
  if(empty($file)) return false;;
  if(is_array($variations)) {
    foreach($variations as $variation){
        $local_path = upload_path($file,$model,$variation,false);
        @unlink($local_path);
    } 
  }
  $use_aws = env('AWS_STATUS',false);    
  if($use_aws) {
    $aws_path = upload_path($file,$model,$variations,true);
    $s3 = AWS::createClient('s3');
    $s3->deleteObject(array(
          'Bucket'     => env('AWS_S3_BUCKET'),
          'Key'        => $aws_path,          
        ));     
  }

}