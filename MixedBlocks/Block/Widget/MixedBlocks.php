<?php
/**
 * GiaPhuGroup Co., Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GiaPhuGroup.com license that is
 * available through the world-wide-web at this URL:
 * https://www.giaphugroup.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Tbb
 * @package     Tbb_MixedBlocks
 * @copyright   Copyright (c) 2018-2019 GiaPhuGroup Co., Ltd. All rights reserved. (http://www.giaphugroup.com/)
 * @license     https://www.giaphugroup.com/LICENSE.txt
 */

namespace Tbb\MixedBlocks\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class MixedBlocks extends Template implements BlockInterface
{
    /**
     * @var \Tbb\MixedBlocks\Model\MBFactory
     */
    protected $mbFactory;
    protected $_registry;
    protected  $productRepository;
    protected $_categoryFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Tbb\MixedBlocks\Model\MBFactory $mbFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Tbb\MixedBlocks\Model\MBFactory $mbFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->productRepository = $productRepository;
        $this->mbFactory = $mbFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve the mbs slider
     *
     * @param \Tbb\MixedBlocks\Model\MB[]
     */
    public function getMBs()
    {

        $collection = $this->mbFactory->create()->getCollection()->addFieldToFilter(
            'status', \Tbb\MixedBlocks\Model\MB::STATUS_ENABLED
        )->setOrder('main_table.order', 'ASC');
        return $collection;
    }


    public function loadMyProduct($sku)
    {
        return $this->productRepository->get($sku);
    }

    public function getCategory($categoryId)
    {

        $category = $this->_categoryFactory->create()->load($categoryId);

        return  $category;
    }

}
