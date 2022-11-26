<?php
/**
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
namespace Custom\Sales\Api;
/**
* @api
*/
interface ApiInterface
{
  /**
   * @api Get Orderdetail
   * @return mixed
   */	
  public function getOrderdetail();
  /**
   * @api Update updateorder
   * @return mixed
   */  
   public function updateorder();
}
