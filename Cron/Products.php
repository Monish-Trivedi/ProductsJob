<?php
namespace TrainingMonish\ProductsJob\Cron;

use Exception;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\CategoryProductLinkInterface;

class Products
{
    /**
    //  * @var CategoryLinkManagementInterface
    //  */
     private $categoryLinkManagement;
     protected $_productCollectionFactory;
     protected $dateTimeFactory;

    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        array $data = []

    ) {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_dateTimeFactory = $dateTimeFactory;

    }

    /**
     * Assigned Product to single/multiple Category
     *
     * @param string $productSku
     * @param int[] $categoryIds
     * @return bool
     */          
    public function assignProductsToCategory(){
		$this->getCategoryLinkManagement()
		->assignProductToCategories(
			$product->getSku(),
			$product->getCategoryIds() 
		);
	}
	private function getCategoryLinkManagement() { 

		if (null === $this->categoryLinkManagement) { 
			$this->categoryLinkManagement = \Magento\Framework\App\ObjectManager::getInstance()
			->get('Magento\Catalog\Api\CategoryLinkManagementInterface'); 
			} 

		return $this->categoryLinkManagement; 
	}

    public function execute() {	

        $dateModel = $this->dateTimeFactory->create();
        $to = $dateModel->gmtDate();
	    //$to = date("Y-m-d h:i:s"); // current date
	    $from = strtotime('-3 day', strtotime($to));   // current date
	    //$from = date('Y-m-d h:i:s', $from); // 3 days before
        $from = $this->_dateModel->gmtDate('Y-m-d' $from);  // 3 days before

    	$productList = $this->_productCollectionFactory->create();
    	$productList->addFieldToFilter('created_at', array('from'=>$from, 'to'=>$to));

    	return $productList;
    
	
    }    
}