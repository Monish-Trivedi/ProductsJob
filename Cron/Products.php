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

    public function __construct(
        CategoryLinkManagementInterface $categoryLinkManagement,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []

    ) {
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->_productCollectionFactory = $productCollectionFactory;
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

	    $to = date("Y-m-d h:i:s"); // current date
	    $from = strtotime('-3 day', strtotime($to));
	    $from = date('Y-m-d h:i:s', $from); // 3 days before

    	$productList = $this->_productCollectionFactory->create();
    	$productList->addFieldToFilter('created_at', array('from'=>$from, 'to'=>$to));

    	return $productList;
    
	
    }    
}