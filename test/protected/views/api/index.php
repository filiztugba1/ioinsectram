<?phpheader('Content-Type: application/json');
json_decode($json);
  if ( json_last_error() === JSON_ERROR_NONE)
  {
    echo $json;
  }else{
    echo 'Json parse error:'.PHP_EOL.$json;

  }
?>