<?php
/**
 * @Author: Coly Cao
 * @Date:   2017-02-04 15:12:31
 * @Last Modified by:   Coly Cao
 * @Last Modified time: 2017-02-05 11:21:46
 */

namespace Colyii\Fuiou;

use Colyii\Fuiou\mobile\MobileSdk;
use Colyii\Fuiou\pc\PcSdk;
use Illuminate\Support\ServiceProvider;

class FuiouServiceProvider extends ServiceProvider {
	public function boot() {
		$this->publishes([
			__DIR__ . '/config/colyii-fuiou.php' => config_path('colyii-fuiou.php'),
		]);
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->mergeConfigFrom(__DIR__ . '/config/colyii-fuiou.php', 'colyii-fuiou');
		//pc 对象绑定
		$this->app->bind('PcFuiou', function () {
			$pcFuiou = new PcSdk();
			$pcFuiou->mchnt_cd = config('colyii-fuiou.mchnt_cd');
			$pcFuiou->username = config('colyii-fuiou.username');
			$pcFuiou->password = config('colyii-fuiou.password');
			$pcFuiou->out_cust_no = config('colyii-fuiou.out_cust_no');
			$pcFuiou->in_cust_no = config('colyii-fuiou.in_cust_no');
			$pcFuiou->loan_in_cust_no = config('colyii-fuiou.loan_in_cust_no');
			$pcFuiou->privateKeyPath = __DIR__ . '/config/key/php_prkey.pem';
			$pcFuiou->publicKeyPath = __DIR__ . '/config/key/php_pbkey.pem';
			$pcFuiou->jzhUrl = config('colyii-fuiou.jzhUrl');
			$pcFuiou->PageUrl = config('colyii-fuiou.PageUrl');
			$pcFuiou->BackUrl = config('colyii-fuiou.BackUrl');
			return $pcFuiou;
		});
		//mobile 对象绑定
		$this->app->bind('MobileFuiou', function () {
			$mobileFuiou = new MobileSdk();
			$mobileFuiou->mchnt_cd = config('colyii-fuiou.mchnt_cd');
			$mobileFuiou->username = config('colyii-fuiou.username');
			$mobileFuiou->password = config('colyii-fuiou.password');
			$mobileFuiou->out_cust_no = config('colyii-fuiou.out_cust_no');
			$mobileFuiou->in_cust_no = config('colyii-fuiou.in_cust_no');
			$mobileFuiou->loan_in_cust_no = config('colyii-fuiou.loan_in_cust_no');
			$mobileFuiou->privateKeyPath = __DIR__ . '/config/key/php_prkey.pem';
			$mobileFuiou->publicKeyPath = __DIR__ . '/config/key/php_pbkey.pem';
			$mobileFuiou->jzhUrl = config('colyii-fuiou.jzhUrl');
			$mobileFuiou->PageUrl = config('colyii-fuiou.PageUrl');
			$mobileFuiou->BackUrl = config('colyii-fuiou.BackUrl');
			return $mobileFuiou;
		});
	}
}
