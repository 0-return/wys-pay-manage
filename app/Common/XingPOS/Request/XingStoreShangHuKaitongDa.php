<?php
namespace App\Common\XingPOS\Request;
/*
	
开通d0


*/
class XingStoreShangHuKaitongDa
{

	public $content=[
		'serviceId'=>'6060660'
	];

    public $sign_content = [];


    public function setBizContent($sign_data = [], $no_sign_data = [])
    {
        $data = array_merge($sign_data, $no_sign_data, $this->content);
        $sign_data = array_merge($this->content, $sign_data);
        $this->content += $data;
        $this->sign_content = $sign_data;
    }

    public function getBizContent()
    {
        return $this->content;
    }

    public function getSignBizContent()
    {
        return $this->sign_content;
    }

}