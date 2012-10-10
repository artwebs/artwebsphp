<?php

class LHB {
	private static $_instance = array();
	protected $model;
	protected $action;
	function LHB($model="",$action=""){
		$this->model=$model;
		$this->action=$action;
	}
    public function set_model($model){
		$this->model=$model;
    }

    public function set_action($action){
		$this->action=$action;
    }
	function _autoload($classname){
		require_once($classname.".class.php");
    }
	public function __set($name ,$value)
    {
        if(property_exists($this,$name))
            $this->$name = $value;
    }

    /**
     +----------------------------------------------------------
     * 自动变量获取
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param $name 属性名称
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------
     */
    public function __get($name)
    {
        return isset($this->$name)?$this->$name:null;
    }

    /**
     +----------------------------------------------------------
     * 系统自动加载ThinkPHP类库
     * 并且支持配置自动加载路径
     +----------------------------------------------------------
     * @param string $classname 对象类名
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    public static function autoload($classname)
    {
        // 检查是否存在别名定义
        if(alias_import($classname)) return ;
        // 自动加载当前项目的Actioon类和Model类
        if(substr($classname,-5)=="Model") {
            require_cache(LIB_PATH.'Model/'.$classname.'.class.php');
        }elseif(substr($classname,-6)=="Action"){
            require_cache(LIB_PATH.'Action/'.$classname.'.class.php');
        }else if(substr($classname,-6)=="Plugin"){
			require_once( APP_PATH.'/Plugins/'.$classname.'.class.php');
		}else {
            // 根据自动加载路径设置进行尝试搜索
            if(C('APP_AUTOLOAD_PATH')) {
                $paths  =   explode(',',C('APP_AUTOLOAD_PATH'));
                foreach ($paths as $path){
                    if(import($path.$classname))
                        // 如果加载类成功则返回
                        return ;
                }
            }
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 取得对象实例 支持调用类的静态方法
     +----------------------------------------------------------
     * @param string $class 对象类名
     * @param string $method 类的静态方法名
     +----------------------------------------------------------
     * @return object
     +----------------------------------------------------------
     */
    static public function instance($class,$method='')
    {
        $identify   =   $class.$method;
        if(!isset(self::$_instance[$identify])) {
            if(class_exists($class)){
                $o = new $class();
                if(!empty($method) && method_exists($o,$method))
                    self::$_instance[$identify] = call_user_func_array(array(&$o, $method));
                else
                    self::$_instance[$identify] = $o;
            }
            else
                halt(L('_CLASS_NOT_EXIST_'));
        }
        return self::$_instance[$identify];
    }




}//类定义结束