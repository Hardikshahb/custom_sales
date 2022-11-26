<?php
/**
 * @category   NameSpace
 * @package    NameSpace_ModuleName
 * @author     Webkul Software Private Limited
 * @copyright  Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license    https://store.webkul.com/license.html
 */
namespace Custom\Sales\Model;

/**
 * ProcessQueueMsg Model
 */
class ProcessQueueMsg
{
    protected $_logger;
	public function __construct(
	\Custom\Sales\Logger\Logger $logger
	)
	{
		$this->_logger = $logger;
	}
    /**
     * process
     * @param $message
     * @return
     */
    public function process($message)
    {
         $this->_logger->info(json_decode($message,true));
    }
}
