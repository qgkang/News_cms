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
		//F方法存储静态数据,ctrl+B查看方法，ctrl+p查看参数
        //数据会保存在Runtime/Data下面，快速缓存data数据
		$id = F('basic_web_config', $data);
		return $id;
	}

	public function select() {
	    //获取缓存数据，
		return F("basic_web_config");
	}

    /*
    快速缓存Data数据，保存到指定的目录
    F('data',$Data,TEMP_PATH);

    获取缓存数据
    $Data = F('data');

    删除缓存数据
    F('data',NULL);
    */

}
