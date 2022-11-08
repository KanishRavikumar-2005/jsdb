<?php 
//CODE BY KANISH SHANMUGA R
//Change Default IV, CIPHER AND KEY FOR INCREASED SECURITY.
//CHANGE ONLY IF YOU KNOW WHAT YOU ARE DOING
//WITHOUT KEY IV AND CIPHER... ENCRYPTION/DECRYPTION OF DB WONT WORK
//MINIR MODIFICATIONS TO THE DATABASE WILL ALSO CRASH IT COMPLETELY PROTEXTING DATA
//USER CAN CHANGE CIPHET METHOD AND ENCRYPTION KEY AND IV IF THE KNOW THAT MAY RESULT
$iv = ";�%P�+�M";//AES-256-CBC requires 16Bytes
//echo strlen($iv);
$key = "�b�B�8i�@0D�j:ՉUQ�=Q�";
$cipher = "aes-256-cbc";

function Encrypt($plaintext, $cipher, $key, $iv){
  return openssl_encrypt($plaintext, $cipher, $key, $options=1, $iv);
}
function Decrypt($cyp, $cipher, $key, $iv){
  return openssl_decrypt($cyp, $cipher, $key, $options=1, $iv);
}

/*
DEFAULT VALUE[Do not delete this comment, this will come useful]
$iv = ";�+�%gPK�";
$key = "�b�B�8i�@0D�j:ՉUQ�=Q�";
$cipher = "aes-256-cbc";
*/



//GET VALUES FROM A JSDB
class Jsdb {
  public function refresh(){
  echo "<script>window.location.assign(window.location.href)</script>";
}
  public function create($jsdbname){
    touch("$jsdbname.jsdb");
    $jsdbf = fopen("$jsdbname.jsdb", 'w');
    $txt = Encrypt("[]", $GLOBALS['cipher'], $GLOBALS['key'], $GLOBALS['iv']);
    fwrite($jsdbf, $txt);
    fclose($jsdbf);
  }
  public function get($file){
    $cipher_gt = $GLOBALS['cipher'];
    $key_gt = $GLOBALS['key'];
    $iv_gt = $GLOBALS['iv'];
    $get_data = file_get_contents($file.'.jsdb');
    $decrypt = Decrypt($get_data, $cipher_gt, $key_gt, $iv_gt);
    return json_decode($decrypt, true) ;
  }
  public function put($file, $content){
    $cipher_gt = $GLOBALS['cipher'];
    $key_gt = $GLOBALS['key'];
    $iv_gt = $GLOBALS['iv'];
    $encrypt = Encrypt($content, $cipher_gt, $key_gt, $iv_gt);
    file_put_contents($file.'.jsdb', $encrypt) or die("Error Putting Data");
  }
  
public function uniqstr($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
  
  public function safe($value){
    $value = htmlentities($value);
    $value = str_replace("`", "'", $value);
    return $value;
  }
  
  public function create_row($code){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $arrayName = array();
    foreach($givnData as $key => $dat){
      $arrayName[$key] = $dat;
    }
    return $arrayName;
  }
  
  public function join_row($array, $array_to_join){
    $array_to_join[] = $array;
    return json_encode($array_to_join);
  }
  
  public function first_row($code){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $arrayName = array();
    foreach($givnData as $key => $dat){
      $arrayName[$key] = $dat;
    }
    return $arrayName."";
  }
  
  
  public function remove_row($file, $code){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $recvDD = $this->get($file);
    foreach($recvDD as $key => $dd){
      $result=array_diff($givnData,$dd);
      if(empty($result)){
        unset($recvDD[$key]);
        $finecd = json_encode(array_values($recvDD));
        $this->put($file, $finecd);
      }   
    }
  
  }
  
  public function update_row($file, $code, $ucode){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $ucode = str_replace("`", '"', $ucode);
    $updData = json_decode($ucode, true);
    $dataR = $this->get($file);
    foreach($dataR as $key => $dd){
      $result=array_diff($givnData,$dd);
      if(empty($result)){
        $arrt_upd = $dataR[$key];
        foreach($updData as $kk => $vv){
          $arrt_upd[$kk] = $vv;
        }
        $dataR[$key] = $arrt_upd;
        
        $finecd = json_encode(array_values($dataR));
        $this->put($file, $finecd);
      }    
    }
  }
  
  public function add_row($file, $code){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $dataV = $this->get($file);
    $dataV[] = $givnData;
    $final = json_encode($dataV);
    $this->put($file, $final);
  }
  
  public function get_row($file, $code){
    $code = str_replace("`", '"', $code);
    $givnData = json_decode($code, true);
    $recvDD = $this->get($file);
    $mmed = [];
    foreach($recvDD as $key => $dd){
      $result=array_diff($givnData,$dd);
      if(empty($result)){
        $mmed[] = $dd;
      }   
    }
    return $mmed;
  }
}
?>
