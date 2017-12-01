<?php

namespace Develo\Designer\Controller\Index;

class Upload extends \Develo\Designer\Controller\Front {

    const UPLOADER_PATH = 'dd_front_designer';

    protected $_fileUploaderFactory;
    protected $_filesystem;
    protected $_storeManager;
    protected $_cataloSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context, 
        \Magento\Framework\Filesystem $filesystem, 
        \Magento\Store\Model\StoreManagerInterface $storeManager, 
        \Magento\Catalog\Model\Session $catalogSession, 
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        parent::__construct($context);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filesystem;
        $this->_storeManager = $storeManager;

        $this->_catalogSession = $catalogSession;
    }

    public function execute() {
        try {
            $uploader = $this->_fileUploaderFactory->create(['fileId' => 'file']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);
            $reader = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $path = $reader->getAbsolutePath(self::UPLOADER_PATH . '/');
            $save = $uploader->save($path);
            if ($save && !empty($save['file'])) {
                $sizes = getimagesize($path . $save['file']);
                $file = $this->_storeManager
                                ->getStore()
                                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
                        self::UPLOADER_PATH . '/' . $save['file'];
                $this->saveMyFiles([
                    'width' => $sizes[0],
                    'height' => $sizes[1],
                    'src' => $file
                ]);
                return $this->sendResponse([
                            'success' => true,
                            'width' => $sizes[0],
                            'height' => $sizes[1],
                            'filename' => $file
                ]);
            } else {
                return $this->sendError('ERROR: UPLOADING FILES!');
            }
        } catch (Exception $ex) {
            return $this->sendError(__('Error') . ': ' . $ex->getMessage());
        }
    }

    protected function saveMyFiles($_fileData) {
        $myFiles = $this->_catalogSession->getDDDesignerFiles();
        if (!$myFiles) {
            $myFilesArr = [];
        } else {
            $myFilesArr = json_decode($myFiles);
        }
        $myFilesArr[] = $_fileData;
        $this->_catalogSession->setDDDesignerFiles(json_encode($myFilesArr));
    }

}
