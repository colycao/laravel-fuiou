Fuiou 富友金账户

安装

composer require colyii/laravel-fuiou dev-master

或者在composer.json中加入

 "require": {
	"colyii/laravel-fuiou": "dev-master"
}

更新依赖 composer update

使用说明

找到 config/app.php 文件

'providers' => [

   Colyii\Fuiou\FuiouServiceProvider::class,
]
运行 php artisan vendor:publish 命令

配置文件 config/colyii-fuiou.php 已经生成，按照要求配置即可
