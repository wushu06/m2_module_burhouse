<?php

namespace Tbb\MixedBlocks\Model\Config\Source;

class Styles implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'green', 'label' => __('Green')],
            ['value' => 'purple', 'label' => __('Purple')],

        ];
    }
}