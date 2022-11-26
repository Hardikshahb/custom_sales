<?php


namespace Custom\Sales\Controller\Adminhtml\Order;

/**
 * Class Save
 *
 * @package Levosoft\Partpicker\Controller\Adminhtml\Imagetag
 */
class Senddetails extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
    protected $orderFactory;
    /**
     * @var \Magento\Framework\MessageQueue\PublisherInterface
    */
    private $publisher;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Psr\Log\LoggerInterface $logger,
	\Magento\Sales\Model\OrderFactory $orderFactory,
	\Magento\Framework\MessageQueue\PublisherInterface $publisher
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->orderFactory = $orderFactory;
        $this->publisher = $publisher;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
		if($order_info = $this->getRequest()->getPostValue("order_info")){
            	$this->publisher->publish('orderdatasync.topic', $order_info);
            	$this->messageManager->addSuccessMessage(__('Order info added in queue'));
            	$resultRedirect->setUrl($this->_redirect->getRefererUrl(),array('active_tab' => 'order_export'));
        	return $resultRedirect;
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
		$this->messageManager->addErrorMessage($e->getMessage());
 		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
        	return $resultRedirect;
        } catch (\Exception $e) {
		$this->logger->critical($e);
		$this->messageManager->addErrorMessage($e->getMessage());
 		$resultRedirect->setUrl($this->_redirect->getRefererUrl());
        	return $resultRedirect;
        }
    }
}
