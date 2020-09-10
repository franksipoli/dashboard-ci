<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geratoken extends MY_Controller {

  public function __construct(){
    parent::__construct();
  }

// JWT.php goes in application/libraries
// example controller function 
// test case: Annotator Authentication (https://github.com/okfn/annotator)

  public function generate_token($user_id){
    $this->load->library("JWT");
    $CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $CONSUMER_TTL = 86400;
    echo $this->jwt->encode(array(
      'consumerKey'=>$CONSUMER_KEY,
      'userId'=>$user_id,
      'issuedAt'=>date(DATE_ISO8601, strtotime("now")),
      'ttl'=>$CONSUMER_TTL
    ), $CONSUMER_SECRET);
  }

  public function degenerate_token($token){
    $this->load->library("JWT");
    $CONSUMER_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $CONSUMER_SECRET = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    return echo $this->jwt->decode($token, $CONSUMER_KEY, true);

  }
}

?>
