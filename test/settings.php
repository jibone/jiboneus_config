<?php
$conf = array(
  "name"        => "test app",
  "enviroment"  => "test"
);

// -- devlopment enviroment
$conf["development"] = array(
  "base_url"  => "localhost"
);

// -- test enviroment
$conf["test"] = array(
  "base_url"  => "test.dev"
);

// -- live enviroment
$conf["production"] = array(
  "base_url"  => "website.com"
);
