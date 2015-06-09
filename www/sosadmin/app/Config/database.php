<?php
class DATABASE_CONFIG {

public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '',
		'login' => '',
		'password' => '',
		'database' => '',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	///===> SERVER ZOIO
	///=====___ para criar as tabelas que o Cake Padrão precisa:
	///=====   .../_contructor/<usuario>/<senha>
	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '127.0.0.1',
		'login' => 'root',
		'password' => 'zoio2010',
		'database' => 'sos_ma',
		'prefix' => '',
		'encoding' => 'utf8',
	);
}
