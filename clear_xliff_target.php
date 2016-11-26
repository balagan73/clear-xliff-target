#!/usr/bin/env php

<?php

if (isset($argv[1])) {
  if ($argv[1] == "--help") {
    $help = "\nThe target units in the xlf file specified as the first\n";
    $help .= "\nparameter will be cleared.\n\n";
    echo($help);
    exit();
  }

  if ($file = file_get_contents($argv[1])) {
    $offset = 0;
    echo("This might take a while depending on file size, patience.");
    while ( $start = stripos($file, '<target', $offset)) {
      $text_start = stripos($file, '>', $start) + 1;
      $lead = substr($file, $start, $text_start - $start);
      $close = stripos($file, '</target>', $start);
      $search = substr($file, $start, $close - $start);
      $offset = $close;
      $file = str_replace($search, $lead, $file);
    } // end of while
    file_put_contents($argv[1] . "cleared", $file);
  }

}
else {
  echo("First parameter should be an xliff/xlf file.\n");
}
