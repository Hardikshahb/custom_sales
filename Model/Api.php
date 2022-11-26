<?php

namespace Custom\Sales\Model;
use Custom\Sales\Api\ApiInterface;

class Api implements ApiInterface
{
	protected $_request;
	protected $_orderFactory;
	private $publisher;

	public function __construct(
		\Magento\Framework\Webapi\Rest\Request $request,
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Magento\Framework\MessageQueue\PublisherInterface $publisher
	) {
		$this->_request = $request;
		$this->_orderFactory = $orderFactory;
		$this->publisher = $publisher;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrderdetail(){

		try{

			$data = $this->_request->getParams();
//echo "hi";exit;
			$orderId = $data['order_id'];
			$order = $this->_orderFactory->create()->loadByIncrementId($orderId);
			//var_dump($order->getId());exit;
			if($order->getId()){
          			$response = ['status' => array("ok"), 'message' => array('success'), 'data' => $order->getData()];
        	return $response;
        		}else{
				$response = ['status' => array("ok"), 'message' => array('success'), 'data' => array("Please enter valid order id")];
        	return $response;
        		} 
		}catch(\Exception $e) {
		    	return ['status' => array("error"), 'message' => array($e->getMessage()), 'data' => []];
		} 
		 
	}
  public function updateorder(){
    
    $data = $this->_request->getBodyParams();
    $orderId = $data['CustOrderDesc']['entity_id'];

    $order = $this->_orderFactory->create()->load($orderId);
    $orderstatus = $data['CustOrderDesc']['order_status'];
    $payment_method = $order->getPayment()->getMethodInstance()->getCode();
    $response = array();

    if($order->getId()) {
      $order->setStatus($orderstatus);
      $order->addStatusHistoryComment('', $order->getStatus());
      $order->save();
      $this->publisher->publish('orderdatasync.topic', json_encode($data));
      $response = ['status' => array("ok"), 'message' => array(__('Order successfully updated'))]; 

    }else {
      $response = ['status' => array("error"), 'message' => array(__('Invlid Order details'))];
    }

    return $response;

  }	
}
