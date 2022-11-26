<?php


namespace Custom\Sales\Controller\Adminhtml\Order;

/**
 * Class Save
 *
 * @package Levosoft\Partpicker\Controller\Adminhtml\Imagetag
 */
class Details extends \Magento\Backend\App\Action
{

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
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Psr\Log\LoggerInterface $logger,
	\Magento\Sales\Model\OrderFactory $orderFactory
    ) {
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->orderFactory = $orderFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
	$orderIncrementId = $this->getRequest()->getParam("order_id");
	if($orderIncrementId){        
		$order = $this->orderFactory->create()->loadByIncrementId($orderIncrementId);
            return $this->jsonResponse($order->getData());
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
