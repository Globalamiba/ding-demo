<?php
/**
 * dingtalk API: dingtalk.oapi.appstore.orders.special_canal.update_order request
 * 
 * @author auto create
 * @since 1.0, 2021.10.12
 */
class OapiAppstoreOrdersSpecialCanalUpdateOrderRequest
{
	/** 
	 * 钉钉订单id
	 **/
	private $dingOrderId;
	
	/** 
	 * 状态。已支付是3，已完成是4，已取消是1
	 **/
	private $status;
	
	private $apiParas = array();
	
	public function setDingOrderId($dingOrderId)
	{
		$this->dingOrderId = $dingOrderId;
		$this->apiParas["ding_order_id"] = $dingOrderId;
	}

	public function getDingOrderId()
	{
		return $this->dingOrderId;
	}

	public function setStatus($status)
	{
		$this->status = $status;
		$this->apiParas["status"] = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.appstore.orders.special_canal.update_order";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->dingOrderId,"dingOrderId");
		RequestCheckUtil::checkNotNull($this->status,"status");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
