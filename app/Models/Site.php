<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema;
use DB;


class Site extends Model{

    public static function mapCollections($collection){
        $return = [];
        foreach($collection as $c){
            $new = (object) $c->resolve();
            array_push($return, $new);
        }
        
        return $return;
    }

    public static function send_mail($view, $email, $subject){
        
         // Always set content-type when sending HTML email
         $headers = "MIME-Version: 1.0" . "\r\n";
         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
         $headers .= "X-Mailer: PHP/" . phpversion(). "\r\n";
         $headers .= "X-Priority: 1". "\r\n";
 
         // More headers
         $headers .= "From:  SITENAME<sitename.com>" . "\r\n";
         $headers .= "Reply-To: support@sitename.com" . "\r\n";
 
         mail($email,$subject,$view,$headers);
    }
}