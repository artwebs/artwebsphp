<?php
	return array(
		'DB_TYPE'               => 'oracle',     // 数据库类型
		'DB_CONNSTR'            => 'oci:dbname=//116.52.157.130:1521/ORCL1;charset=utf8', // 数据库连接字符串
		'DB_USER'               => '',      // 用户名
		'DB_PWD'                => '',          // 密码


		'21DB_TYPE'               => 'oracle',     // 数据库类型
		'21DB_CONNSTR'            => 'oci:dbname=//116.52.157.130:1521/ORCL1;charset=utf8', // 数据库连接字符串
		'21DB_USER'               => '',      // 用户名
		'21DB_PWD'                => '',          // 密码

		'21OCIDB_TYPE'               => 'oracleOci',     // 数据库类型
		'21OCIDB_CONNSTR'            => '(DESCRIPTION =    (ADDRESS = (PROTOCOL = TCP)(HOST = 116.55.248.21)(PORT = 1521))    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = orcl)    )  )', // 数据库连接字符串
		'21OCIDB_USER'               => '',      // 用户名
		'21OCIDB_PWD'                => '',          // 密码

		'VDDB_TYPE'               => 'oracleOci',     // 数据库类型
		'VDDB_CONNSTR'            => '(DESCRIPTION =    (ADDRESS = (PROTOCOL = TCP)(HOST = 116.52.157.130)(PORT = 1521))    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = orcl1)    )  )', // 数据库连接字符串
		'VDDB_USER'               => '',      // 用户名
		'VDDB_PWD'                => '',          // 密码

		'Query_KmWsUrl'         => 'http://10.167.74.4:8080/unidata/services/UniDataService?wsdl',          // 密码
		'Test_WsUrl'         => 'http://localhost:8686/LHBSystem/soap.php?wsdl',
		'SESSION_FLAGE'		   =>true,

//		'App_DB_TYPE'               => 'mysql',     // 数据库类型
//		'App_DB_CONNSTR'            => 'mysql:host=192.168.220.144;dbname=sqlartwebsnu', // 数据库连接字符串
//		'App_DB_USER'               => 'root',      // 用户名
//		'App_DB_PWD'                => 'windows123',          // 密码

		'MSDB_TYPE'               => 'mssql',     // 数据库类型
		'MSDB_CONNSTR'            => 'mssql:host=localhost,1433;dbname=artwebs;charset=utf-8', // 数据库连接字符串
		'MSDB_USER'               => 'sa',      // 用户名
		'MSDB_PWD'                => 'windows123',          // 密码

		'SHOW_ERROR'           =>true,
//		'SMARTY_CACHE'		   =>true,

		'PDO_CASE'=>'UPPER',

		'SESSION_FAILURL'	   =>'http://localhost/LHBSystem_1/index.php?mod=page&act=index',
		'WSDL_SERVER_KEY'		=>array('user8'=>'测试用户','hhga'=>'红河公安'),
		'UITEST'				=>true,

		'DICVERSION'			=>'1.03',

	);
?>
