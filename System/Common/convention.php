<?php
	return array(
		'DB_TYPE'               => 'oracle',     // 数据库类型
		'DB_CONNSTR'            => 'oci:dbname=//116.52.157.130:1521/ORCL1;charset=utf8', // 数据库连接字符串
		'DB_USER'               => '',      // 用户名
		'DB_PWD'                => '',          // 密码

//		'DB_TYPE'               => 'mysql',     // 数据库类型
//		'DB_CONNSTR'            => 'mysql:host=localhost;dbname=equipment', // 数据库连接字符串
//		'DB_USER'               => '',      // 用户名
//		'DB_PWD'                => '',          // 密码
//
//		'DB_TYPE'               => 'mssql',     // 数据库类型
//		'DB_CONNSTR'            => 'mssql:host=220.165.8.83,1433;dbname=YnFire', // 数据库连接字符串
//		'DB_CONNSTR'            => 'sqlsrv:server=221.213.85.98,1433;Database=AgentUser;', // 数据库连接字符串
//		'DB_USER'               => '',      // 用户名
//		'DB_PWD'                => '',          // 密码

//		'DB_TYPE'               => 'pgsql',     // 数据库类型
//		'DB_CONNSTR'            => 'pgsql:host=localhost;dbname=palm', // 数据库连接字符串
//		'DB_USER'               => '',      // 用户名
//		'DB_PWD'                => '',          // 密码

//		'21OCIDB_TYPE'               => 'oracleOci',     // 数据库类型
//		'21OCIDB_CONNSTR'            => '(DESCRIPTION =    (ADDRESS = (PROTOCOL = TCP)(HOST = 116.55.248.21)(PORT = 1521))    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = orcl)    )  )', // 数据库连接字符串
//		'21OCIDB_USER'               => '',      // 用户名
//		'21OCIDB_PWD'                => '',          // 密码

		'Sys_DB_TYPE'               => 'sqlite',     // 数据库类型
		'Sys_DB_CONNSTR'            => 'sqlite:'.LHB_PATH.'/Data/~system@.db', // 数据库连接字符串
		'Sys_DB_USER'               => '',      // 用户名
		'Sys_DB_PWD'                => '',          // 密码

		'App_DB_TYPE'               => 'sqlite',     // 数据库类型
		'App_DB_CONNSTR'            => 'sqlite:'.APP_PATH.'/Data/~app@.db', // 数据库连接字符串
		'App_DB_USER'               => '',      // 用户名
		'App_DB_PWD'                => '',          // 密码


		'OPER_MODULE'          => 'mod', // 默认语言
	    'OPER_ACTION'          => 'act', // 默认语言

        'APP_FILE_CASE'         => false,   // 是否检查文件的大小写 对Windows平台有效
	    /* 默认设定 */
	    'DEFAULT_APP'           => '@',     // 默认项目名称，@表示当前项目
	    'DEFAULT_GROUP'         => 'Home',  // 默认分组
	    'DEFAULT_MODULE'        => 'Index', // 默认模块名称
	    'DEFAULT_ACTION'        => 'index', // 默认操作名称
	    'DEFAULT_CHARSET'       => 'utf-8', // 默认输出编码
	    'DEFAULT_TIMEZONE'      => 'PRC',	// 默认时区
	    'DEFAULT_AJAX_RETURN'   => 'JSON',  // 默认AJAX 数据返回格式,可选JSON XML ...
	    'DEFAULT_THEME'    => 'default',	// 默认模板主题名称
	    'DEFAULT_LANG'          => 'zh-cn', // 默认语言

	    'TMPL_TEMPLATE_SUFFIX'  => '.tpl',     // 默认模板文件后缀
	    'TMPL_L_DELIM'          => '{',			// 模板引擎普通标签开始标记
    	'TMPL_R_DELIM'          => '}',			// 模板引擎普通标签结束标记

    	'DATA_XMLI_ROOTPATH'            =>'/root/value',
    	'DATA_XMLI_RETURNFLAG'            =>'返回正常',
    	'DATA_XMLII_ROOTPATH'            =>'/root/value',
    	'DATA_XMLII_RETURNFLAG'            =>'返回正常',

    	'App_LogClass'         =>array("debug"=>1,"info"=>2,"warn"=>3,"error"=>4,"fatal"=>5),
		'App_LogLevel'		   =>'debug',
		'App_LogFilePath'      =>APP_PATH."/Log",
		'App_LogFileName'      =>'app_log[date].php',

		'WSDL_ClassName'			   =>"palm",
		'WSDL_NameSpace'			   =>"http://palm/",
		'WSDL_Model'			   =>"Service",
		'WSDL_File'			   =>array('services.wsdl'),//多个
		'WSDL_Server'			   =>array('services.wd'),//多个

		'PHP_JAVA_BRIDGE'	   =>'http://localhost:8585/JavaBridge/java/Java.inc',


		'SESSION_FLAGE'		   =>false,
		'SESSION_CONTROL'	   =>array(
										array('Manage'=>array("index"=>""),),//模块 不限制的行为对象
										array(),//行为对象
									   ),
		'SESSION_KEY'		   =>"username",
		'SESSION_FAILURL' 	   =>"index.php?error=[error]",

		'SHOW_ERROR'           =>true,
		'CATCH_ERROR'		   =>true,

		'CHARSET_FLAG'		   =>true,//是否设页面编码
		'CHARSET'			   =>"utf-8",

		'DEFAULTFILE_CREAT'		=>false,//不创建默认文件

		'SMARTY_CACHE'			=>false,

		'JAVA_OBJECT'			=>array(
										"Method"=>"com.lhb.method.Method",
										"System"=>"java.lang.System",
										"LHBMap"=>"com.lhb.object.LHBMap",
										"CallPages"=>"com.lhb.thread.CallPages",
										"CountryWide"=>"com.countrywide.Server",
								),

		'XMLDEFAULTFIELD'	    =>array('efield','cfield','dpfield','dfield',
								'rfield','type','rowsonlyone','dicobject'),

		'RR_DEFAULTNOPARA'		=>array('SQLiteManager_currentTheme','SQLiteManager_currentLangue'
								,'PHPSESSID'),
		'PDO_CASE'				=>'LOWER',//UPPER,LOWER
		'DICUIGET'				=>false,
		'SESSIONTYPE'			=>'FILE',//FILE\PART
		'WSDL_SERVER_KEY'		=>array('user8'=>'测试用户'),
		'RESPONSE_SAVEDAY'		=>'7',
		'RESPONSE_SAVEFLAG'		=>false,

		'UiItemControl'			=>array('DROPDOWNLIST','RADIOLIST','COMBOBOX','CHECKBOXLISTTEXTBOX'),
		'XMLUIFILENAME'				=>"XmlUi",

		'DICVERSION'			=>'1.00',
	);
?>
