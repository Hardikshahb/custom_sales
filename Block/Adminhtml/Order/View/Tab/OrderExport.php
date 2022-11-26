<?php

namespace Custom\Sales\Block\Adminhtml\Order\View\Tab;

class OrderExport extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_template = 'tab/order/view/export.phtml';
    /**
     * @var \Magento\Framework\Registry
     */
    private $_coreRegistry;

    /**
     * View constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        array                                   $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * Retrieve order model instance
     *
     * @return int
     *Get current id order
     */
    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }

    /**
     * Retrieve order increment id
     *
     * @return string
     */
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }

    /**
     * Retrieve order increment id
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getOrder()->getCustomerEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Order Export');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Order Export');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}