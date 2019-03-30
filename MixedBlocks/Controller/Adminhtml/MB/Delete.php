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

namespace Tbb\MixedBlocks\Controller\Adminhtml\MB;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Tbb_MixedBlocks::mb_delete';

    /**
     * Delete MB
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $mbId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($mbId && (int) $mbId > 0) {
            try {
                $model = $this->_objectManager->create('Tbb\MixedBlocks\Model\MB');
                $model->load($mbId);
                $model->delete();
                $this->messageManager->addSuccess(__('The MB has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to the question grid
                return $resultRedirect->setPath('*/*/index');
            }
        }
        // display error message
        $this->messageManager->addError(__('MB doesn\'t exist any longer.'));
        // go to the question grid
        return $resultRedirect->setPath('*/*/index');
    }
}
