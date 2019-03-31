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

namespace Tbb\MixedBlocks\Model\MB;

use Tbb\MixedBlocks\Model\ResourceModel\MB\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use Tbb\MixedBlocks\Model\MB\FileInfo;
use Magento\Framework\Filesystem;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Tbb\MixedBlocks\Model\ResourceModel\MB\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $mbCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $mbCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $mbCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Tbb\MixedBlocks\Model\MB $mb */
        foreach ($items as $mb) {
            $mb = $this->convertValues($mb);
            $this->loadedData[$mb->getId()] = $mb->getData();
        }

        // Used from the Save action
        $data = $this->dataPersistor->get('mixed_blocks');
        if (!empty($data)) {
            $mb = $this->collection->getNewEmptyItem();
            $mb->setData($data);
            $this->loadedData[$mb->getId()] = $mb->getData();
            $this->dataPersistor->clear('mixed_blocks');
        }

        return $this->loadedData;
    }

    /**
     * Converts image data to acceptable for rendering format
     *
     * @param \Tbb\MixedBlocks\Model\MB $mb
     * @return \Tbb\MixedBlocks\Model\MB $mb
     */
    private function convertValues($mb)
    {
        $fileName = $mb->getImage();
        $image = [];
        if($mb->getImageUrl() !== '') {
            if ($this->getFileInfo()->isExist($fileName)) {
                $stat = $this->getFileInfo()->getStat($fileName);
                $mime = $this->getFileInfo()->getMimeType($fileName);
                $image[0]['name'] = $fileName;
                $image[0]['url'] = $mb->getImageUrl();
                $image[0]['size'] = isset($stat) ? $stat['size'] : 0;
                $image[0]['type'] = $mime;
            }
            $mb->setImage($image);
        }

        return $mb;
    }

    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}
