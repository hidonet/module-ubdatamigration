<?php

namespace Ubertheme\Ubdatamigration\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class Index extends \Ubertheme\Ubdatamigration\Controller\Adminhtml\Index
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute(){
        //we will save souce of this lib at pub folder
        $pubDir = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::PUB);
        $toolDir = $pubDir->getAbsolutePath('ub-tool/');
        if (!file_exists($toolDir.'index.php')){
            $reader = $this->_objectManager->get('Magento\Framework\Module\Dir\Reader');
            $sourceDir = $reader->getModuleDir('', 'Ubertheme_Ubdatamigration').'/lib';
            $helper = $this->_objectManager->get('Ubertheme\Ubdatamigration\Helper\File');
            $helper->xcopy($sourceDir, $toolDir, 0775);
        }
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->getResultPageFactory()->create();
        $resultPage->setActiveMenu('Ubertheme_Ubdatamigration::migrate');
        $resultPage->addBreadcrumb(__('Migrate'), __('Migrate'));
        $resultPage->getConfig()->getTitle()->prepend(__('UB Data Migration'));

        return $resultPage;
    }

    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function getResultPageFactory(){
        return $this->resultPageFactory;
    }
}