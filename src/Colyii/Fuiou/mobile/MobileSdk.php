<?php
/**
 * @Author: Coly Cao
 * @Date:   2017-01-19 16:56:05
 * @Last Modified by:   coly
 * @Last Modified time: 2017-02-16 15:05:05
 */
namespace Colyii\Fuiou\mobile;

use Colyii\Fuiou\pc\HelperFunction;

/**
 * 富友金账户
 */
class MobileSdk {
	public $mchnt_cd;
	public $username;
	public $password;
	public $out_cust_no;
	public $in_cust_no;
	public $loan_in_cust_no;
	public $privateKeyPath;
	public $publicKeyPath;
	public $jzhUrl;
	public $PageUrl;
	public $BackUrl;

	/**
	 * 开户注册
	 * @param  [array] $params [开户参数]
	 * @return [object]         [返回处理数据]
	 */
	public function reg(array $params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'city_id' => $params['city_id'], //开户行地区代码
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'parent_bank_id' => $params['parent_bank_id'], //开户行行别
			'bank_nm' => $params['bank_nm'], //开户行支行名称
			'capAcntNm' => '', //提现账户开户名
			'capAcntNo' => $params['capAcntNo'], //银行账户卡号
			'cust_nm' => $params['cust_nm'], //银行账户户名
			'certif_tp' => 0, //证件类型
			'certif_id' => $params['certif_id'], //身份证号码/证件
			'mobile_no' => $params['mobile_no'], //手机号码
			'email' => '', //邮箱地址
			'password' => '', //提现密码
			'lpassword' => '', //登录密码
			'rem' => '',
		);

		return $this->post('reg', $data);
	}

	/**
	 * APP开户注册
	 * @param  [array] $params [开户参数]
	 * @return [object]         [返回处理数据]
	 */
	public function appWebReg(array $params, $signature) {
		$data = array(
			'ver' => '0.44',
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'user_id_from' => $params['user_id_from'], //用户在商户系统的标志
			'mobile_no' => $params['mobile_no'], //手机号码
			'cust_nm' => $params['cust_nm'], //姓名
			'certif_tp' => 0, //证件类型
			'certif_id' => $params['certif_id'], //身份证号码/证件
			'email' => $params['email'], //邮箱地址
			'city_id' => $params['city_id'], //开户行地区代码
			'parent_bank_id' => $params['parent_bank_id'], //开户行行别
			'bank_nm' => $params['bank_nm'], //开户行支行名称
			'capAcntNo' => $params['capAcntNo'], //银行账户卡号
			'page_notify_url' => $this->PageUrl . '/webReg', //商户返回地址
			'back_notify_url' => $this->BackUrl . '/webReg', //商户后台通知地址
		);

		return $this->formPost('app/appWebReg', $data, $signature);
	}

	/**
	 * app 快捷充值接口
	 * @param array $params
	 * @return string
	 */
	public function appRecharge500002(array $params, $signature) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'login_id' => $params['login_id'], //用户id
			'amt' => $params['amt'], //充值金额
			'page_notify_url' => $this->PageUrl . '/recharge', //商户返回地址
			'back_notify_url' => $this->BackUrl . '/recharge', //商户后台通知地址
		);

		return $this->formPost('app/500002', $data, $signature);
	}
	/**
	 * app 提现接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function appCash(array $params, $signature) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'login_id' => $params['login_id'], //提现金额
			'amt' => $params['amt'], //解冻金额
			'page_notify_url' => $this->PageUrl . '/cash', //商户返回地址
			'back_notify_url' => $this->BackUrl . '/cash', //商户后台通知地址
		);
		return $this->formPost('app/500003', $data, $signature);
	}

	/**
	 * 商户P2P网站免登录用户更换银行卡接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function changeCard2($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'login_id' => $params['login_id'], //用户登录ID
			'page_notify_url' => $this->PageUrl . '/changeCard2', //商户返回地址
		);

		return $this->formPost('changeCard2', $data);
	}

	/**
	 * 预授权接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function preAuth($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //出账账户
			'in_cust_no' => $params['in_cust_no'], //入账账户
			'amt' => $params['amt'], //预授权金额
			'rem' => '',
		);

		return $this->post('preAuth', $data);
	}

	/**
	 * 预授权撤销接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function preAuthCancel($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //出账账户
			'in_cust_no' => $params['in_cust_no'], //入账账户
			'contract_no' => $params['contract_no'], //预授权合同号
			'rem' => '',
		);

		return $this->post('preAuthCancel', $data);
	}

	/**
	 * 转账(商户与个人之间)
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function transferBmu($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //付款登录账户
			'in_cust_no' => $params['in_cust_no'], //收款登录账户
			'amt' => $params['amt'], //转账金额
			'contract_no' => $params['contract_no'], //预授权合同号
			'rem' => '',
		);

		return $this->post('transferBmu', $data);
	}

	/**
	 * 划拨(个人与个人之间)
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function transferBu($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //付款登录账户
			'in_cust_no' => $params['in_cust_no'], //收款登录账户
			'amt' => $params['amt'], //划拨金额
			'contract_no' => $params['contract_no'], //预授权合同号
			'rem' => '',
		);

		return $this->post('transferBu', $data);
	}

	/**
	 * 冻结
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function freeze($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'cust_no' => $params['cust_no'], //冻结目标登录账户
			'amt' => $params['amt'], //冻结金额
			'rem' => '',
		);

		return $this->post('freeze', $data);
	}

	/**
	 * 转账预冻结
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function transferBmuAndFreeze($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //付款登录账户
			'in_cust_no' => $params['in_cust_no'], //收款登录账户
			'amt' => $params['amt'], //转账金额
			'rem' => '',
		);

		return $this->post('transferBmuAndFreeze', $data);
	}

	/**
	 * 划拨预冻结
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function transferBuAndFreeze($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(), //订单号
			'out_cust_no' => $params['out_cust_no'], //付款登录账户
			'in_cust_no' => $params['in_cust_no'], //付款登录账户
			'amt' => $params['amt'], //转账金额
			'rem' => '',
		);

		return $this->post('transferBuAndFreeze', $data);
	}

	/**
	 * 冻结到冻结接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function transferBuAndFreeze2Freeze($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'out_cust_no' => $params['out_cust_no'], //付款登录账户
			'in_cust_no' => $params['in_cust_no'], //收款登录账户
			'amt' => $params['amt'], //转账金额
			'rem' => '',
		);

		return $this->post('transferBuAndFreeze2Freeze', $data);
	}

	/**
	 * 解冻
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function unFreeze($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'cust_no' => $params['cust_no'], //解冻目标登录账户
			'amt' => $params['amt'], //解冻金额
			'rem' => '',
		);

		return $this->post('unFreeze', $data);
	}

	/**
	 * 余额查询-交易查询直连接口列表
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function balanceAction($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'mchnt_txn_dt' => isset($params['mchnt_txn_dt']) ? $params['mchnt_txn_dt'] : date('Ymd'), //交易日期
			'cust_no' => $params['cust_no'], //待查询的登录帐户
		);

		return $this->post('BalanceAction', $data);
	}

	/**
	 * 明细查询接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function query($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'user_ids' => $params['user_ids'], //用户登录ID
			'start_day' => $params['start_day'], //起始时间
			'end_day' => $params['end_day'], //截止时间（起止时间不能跨月）
		);

		return $this->post('query', $data);
	}

	/**
	 * 交易查询接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function queryTxn($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'busi_tp' => $params['busi_tp'], //交易类型
			'start_day' => $params['start_day'], //起始时间
			'end_day' => $params['end_day'], //截止时间（查询范围只允许在31天内或31天前）
			'txn_ssn' => $params['txn_ssn'], //交易流水
			'cust_no' => $params['cust_no'], //交易用户
			'txn_st' => $params['txn_st'], //交易状态
			'remark' => $params['remark'], //交易备注
			'page_no' => $params['page_no'], //页码
			'page_size' => $params['page_size'], //每页条数
		);

		return $this->post('queryTxn', $data);
	}

	/**
	 * 充值提现查询接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function querycztx($params) {
		$data = array(
			'ver' => '0.44',
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'busi_tp' => $params['busi_tp'], //交易类型（PW11 充值、PWTX 提现、PWTP 退票）
			'txn_ssn' => $params['txn_ssn'], //交易流水
			'start_time' => $params['start_time'], //起始时间，格式：yyyy-MM-dd HH:mm:ss
			'end_time' => $params['end_time'], //截止时间（查询范围只允许在31天内或31天前）
			'cust_no' => $params['cust_no'], //交易用户
			'txn_st' => $params['txn_st'], //交易状态
			'page_no' => $params['page_no'], //页码
			'page_size' => $params['page_size'], //每页条数
		);

		return $this->post('querycztx', $data);
	}

	/**
	 * 用户信息查询接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function queryUserInfs($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'mchnt_txn_dt' => isset($params['mchnt_txn_dt']) ? $params['mchnt_txn_dt'] : date('Ymd'), //交易日期
			'user_ids' => $params['user_ids'], //待查询的登录帐户列表
		);

		return $this->post('queryUserInfs', $data);
	}

	/**
	 * 用户信息查询接口（目前只支持个人用户）
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function queryUserInfs_v2($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'mchnt_txn_dt' => isset($params['mchnt_txn_dt']) ? $params['mchnt_txn_dt'] : date('Ymd'), //交易日期
			'user_ids' => $params['user_ids'], //待查询的登录帐户列表
			'user_idNos' => $params['user_idNos'], //待查询的登录省份证列表
			'user_bankCards' => $params['user_bankCards'], //待查询的登录银行卡列表
		);

		return $this->post('queryUserInfs_v2', $data);
	}

	/**
	 * 用户更换银行卡查询接口
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
	public function queryChangeCard($params) {
		$data = array(
			'mchnt_cd' => $this->mchnt_cd,
			'mchnt_txn_ssn' => isset($params['mchnt_txn_ssn']) ? $params['mchnt_txn_ssn'] : HelperFunction::buildOn(),
			'login_id' => $params['login_id'], //用户登录ID
			'txn_ssn' => $params['txn_ssn'], //请求流水
		);

		return $this->post('queryChangeCard', $data);
	}

	public function formPost($url, $data, $signature) {
		$data['signature'] = $signature;
		$result = HelperFunction::buildForm($data, $this->jzhUrl . $url . '.action');
		return $result;
	}

	/**
	 * CURL POST 请求富友
	 * @param  [type] $url  请求接口 url
	 * @param  [type] $data 请求数据
	 * @return [type]       返回处理结果
	 */
	public function post($url, $data) {
		$data['signature'] = $this->rsaSign($data, $url);
		$ch = curl_init();

		$fuiou_url = $this->jzhUrl . $url . '.action';
		curl_setopt($ch, CURLOPT_URL, $fuiou_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
			http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		$result = curl_exec($ch);
		curl_close($ch);

		return $this->handle($url, $data, $result);
	}

	/**
	 * 处理返回结果
	 * @param  [string] $url    请求接口名称
	 * @param  [array] $data   请求数据
	 * @param  [xml] $result 返回结果
	 * @return [type]         对象
	 */
	public function handle($url, $data, $result) {
		$r = false;
		//返回数据延签
		if ($this->rsaVerify($result)) {
			$plain = HelperFunction::xml_object($result)->plain;
			if ('0000' == $plain->resp_code) {
				$r = $plain; //返回对象
			} else {
				$r = HelperFunction::log($url, $plain->resp_code, $data, HelperFunction::pinjie_rsaSign($data, $url)); //返回数组
			}
		}
		return $r;
	}

	/**
	 * RSA签名
	 * @param $data 待签名数据(按照文档说明拼成的字符串)
	 * @param $private_key_path 商户私钥文件路径
	 * return 签名结果
	 */
	public function rsaSign($data, $url = '') {
		$data = HelperFunction::pinjie_rsaSign($data, $url);
		$private_key_path = $this->privateKeyPath;
		$priKey = file_get_contents($private_key_path);
		$res = openssl_get_privatekey($priKey);
		openssl_sign($data, $sign, $res);
		openssl_free_key($res);
		//base64编码
		$sign = base64_encode($sign);
		return $sign;
	}

	/**
	 * RSA验签
	 * @param $data 待签名数据(如果是xml返回则数据为<plain>标签的值,包含<plain>标签，如果为form(key-value，一般指异步返回类的)返回,则需要按照文档中进行key的顺序进行，value拼接)
	 * @param $ali_public_key_path 富友的公钥文件路径
	 * @param $sign 要校对的的签名结果
	 * return 验证结果
	 */
	public function rsaVerify($data, $form = false) {
		$result = false;

		$ali_public_key_path = $this->publicKeyPath;
		$pubKey = file_get_contents($ali_public_key_path);
		$res = openssl_get_publickey($pubKey);

		if (is_array($data) && true === $form) {
			$sign = $data['signature']; //去掉返回签名值
			$data = HelperFunction::pinjie_rsaVerify($data);
			$result = (bool) openssl_verify($data, base64_decode($sign), $res);
		} else {
			try {
				if (is_object($object = HelperFunction::xml_object($data))) {
					$sign = $object->signature;
					//正则匹配 data
					$pattern = "/.*?<ap>(.*?)<signature>.*?/";
					if (preg_match($pattern, $data, $arr)) {
						$result = (bool) openssl_verify($arr[1], base64_decode($sign), $res);
					}
				}
			} catch (Exception $e) {
				throw $e;
			}
		}
		openssl_free_key($res);

		return $result;
	}
}
