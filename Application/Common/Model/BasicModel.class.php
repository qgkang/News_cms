<?php
namespace Common\Model;
use Think\Model;

/**
 * 基本设置
 * @author  singwa
 */
class BasicModel extends Model {

	public function __construct() {

	}

	public function save($data = array()) {
		if(!$data) {
			throw_exception('没有提交的数据');
		}
		//F方法存储静态数据
		$id = F('basic_web_config', $data);
		return $id;
	}

	public function select() {
	    //获取缓存数据
		return F("basic_web_config");
	}




}
