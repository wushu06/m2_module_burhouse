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

namespace Tbb\MixedBlocks\Model\MB\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \Tbb\MixedBlocks\Model\MB
     */
    protected $mb;

    /**
     * Constructor
     *
     * @param \Tbb\MixedBlocks\Model\MB $mb
     */
    public function __construct(\Tbb\MixedBlocks\Model\MB $mb)
    {
        $this->mb = $mb;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->mb->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
