<?php

function redirect($to)
{
  return header("Location: {$to}");
}

function extract_file($value, $pathType, ?bool $concatenated = false)
{
  if(preg_match('/[.\/]/', $value))
  {
    [$folder, $file] = extract_folder($value, $pathType);
  }
  else
  {
    $folder = '';
    $file = $value;
  }

  $filePath = constant(strtoupper($pathType) . '_PATH');

  if(!file_exists($filePath . $folder . $file . '.php'))
  {
    if(!file_exists($filePath . $folder . $file .'.'. strtolower($pathType)))
    {
      throw new Exception("{$pathType} file {$file} not found in {$filePath}{$folder}");
    }
  }

  return ($concatenated)
  ? $folder . $file
  : [$folder, $file];
}

function extract_folder($value, $pathType)
{
  $array = preg_split('/[.\/]/', $value);
  $arrayCount = count($array);

  $filePath = constant(strtoupper($pathType) .'_PATH');
  $file = $array[$arrayCount-1];
  $folder = '';

  for($i = 0; $i < $arrayCount-1; $i++)
  {
    $folder = $folder . $array[$i] . '/';

    if(!is_dir($filePath . $folder))
    {
      throw new Exception ("Folder {$array[$i]} not found in ". $filePath);
    }
  }

  return [$folder, $file];
}