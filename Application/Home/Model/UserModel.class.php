<?php 
namespace Home\Model;
use Think\Model;

class UserModel {
	public function checkUser($name,$pwd,$login = false){
		$user_model  = new UserModel();
		$user = M("user");
		$pwd =$user_model->do_mencrypt($pwd,"1234");
		$res = $user->where(array('username'=>$name))->find();
		//var_dump ($res);
        if($login){
			if(empty($res)||$pwd != $res['password']){
				return false;
			}
		}else{
			if(empty($res)){
				return true;
            }
            else{
                return false;
            }
		}
		return true;
		//$user->where('username='.$name)->select();
	}
	
	
	public function addUser($data){
		$user_model  = new UserModel();
        $data['password'] = $user_model->do_mencrypt($data['password'],"1234");
		$user = M("user");
		$res = $user->where(array('username'=>$name))->find();
		if(empty($res)){
			$res = $user->add($data);
			return $res;
		}
		return false;
	}
	//加密函数
	private function do_mencrypt($input, $key){
		$input = str_replace("　", "", trim($input));
		$input = str_replace("\n", "", $input);
		$input = str_replace("\t", "", $input);
		$input = str_replace("\r", "", $input);
		$key = substr(md5($key), 0, 24);
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$encrypted_data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return trim(chop(base64_encode($encrypted_data)));
	}
	
	//解密函数
	private function do_mdecrypt($input, $key){
		$input = str_replace("\n", "", $input);
		$input = str_replace("\t", "", $input);
		$input = str_replace("\r", "", $input);
		$input = trim(chop(base64_decode($input)));
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
		$key = substr(md5($key), 0, 24);
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$decrypted_data = mdecrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return trim(chop($decrypted_data));
	}
}
