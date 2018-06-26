<?php

namespace Develodesign\Designer\Helper;

class Opengraph extends \Magento\Framework\App\Helper\AbstractHelper {

    protected $_modelShare;
    
    protected $_modelShareLoaded;
    
    protected $_request;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Develodesign\Designer\Model\ShareFactory $modelShare,
        \Magento\Framework\App\RequestInterface $request    
            ) {
        
        parent::__construct($context);
        $this->_modelShare = $modelShare;
        $this->_request = $request;
    }
    
    public function getOpenGraphImage() 
    {
        $designId = $this->_request->getParam('design_id');
        if(!$designId) {
            return;
        }
        $this->_modelShareLoaded = $this->_modelShare->create()
                ->load($designId, 'share_unique_id');
        
        if(!$this->_modelShareLoaded->getId() || !$this->_modelShareLoaded->getShareUrl()) {
            return;
        }
        
        return $this->_modelShareLoaded->getShareUrl();
    }
    
    public function getOpenGraphShareUrl()
    {
        $designId = $this->_request->getParam('design_id');
        if(!$designId) {
            return;
        }
        $this->_modelShareLoaded = $this->_modelShare->create()
                ->load($designId, 'share_unique_id');
        
        if(!$this->_modelShareLoaded->getId() || !$this->_modelShareLoaded->getShareUrl()) {
            return;
        }
        
        return $this->_modelShareLoaded->getShareUrlFull();
    }
}
