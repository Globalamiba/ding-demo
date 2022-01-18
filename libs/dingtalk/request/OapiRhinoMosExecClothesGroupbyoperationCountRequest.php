<?php
/**
 * dingtalk API: dingtalk.oapi.rhino.mos.exec.clothes.groupbyoperation.count request
 * 
 * @author auto create
 * @since 1.0, 2020.03.07
 */
class OapiRhinoMosExecClothesGroupbyoperationCountRequest
{
	/** 
	 * 请求参数
	 **/
	private $request;
	
	private $apiParas = array();
	
	public function setRequest($request)
	{
		$this->request = $request;
		$this->apiParas["request"] = $request;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getApiMethodName()
	{
		return "dingtalk.oapi.rhino.mos.exec.clothes.groupbyoperation.count";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
