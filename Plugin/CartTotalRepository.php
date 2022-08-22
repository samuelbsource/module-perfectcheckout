<?php
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Plugin;

use Magento\Quote\Api\Data\TotalsItemExtensionFactory;
use Magento\Quote\Api\Data\TotalsInterface;
use PerfectShapes\PerfectCheckout\Api\Data\TotalsItemChildInterfaceFactory;
use Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory;

/**
 * Extends the quote item with simple product data when it is a configurable product.
 */
class CartTotalRepository
{
    /**
     * @var TotalsItemExtensionFactory
     */
    private $extensionFactory;

    /**
     * @var TotalsItemChildInterfaceFactory
     */
    private $totalsItemChildFactory;

    /**
     * You might be asking why I am using the collection factory instead of the repository.
     * The reason is that the repository does not let me search by item id, to use it I need to know
     * the quote id which is not available in the context of this plugin.
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Constructor
     *
     * @param TotalsItemExtensionFactory $extensionFactory
     * @param TotalsItemChildInterfaceFactory $totalsItemChildFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        TotalsItemExtensionFactory $extensionFactory,
        TotalsItemChildInterfaceFactory $totalsItemChildFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->totalsItemChildFactory = $totalsItemChildFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Set extension attributes on each totals item.
     *
     * @param \Magento\Quote\Model\Cart\CartTotalRepository $subject
     * @param TotalsInterface $result
     * @return TotalsInterface
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGet(
        \Magento\Quote\Model\Cart\CartTotalRepository $subject,
        TotalsInterface $result
    ) {
        foreach ($result->getItems() as $item) {
            $this->setItemExtensionAttributes($item);
        }
        return $result;
    }

    /**
     * Set extension attributes for the item.
     *
     * @param \Magento\Quote\Model\Cart\Totals\Item $item
     */
    private function setItemExtensionAttributes(\Magento\Quote\Model\Cart\Totals\Item $item)
    {
        if ($item->getExtensionAttributes() === null) {
            $extensionAttributes = $this->extensionFactory->create();
            $item->setExtensionAttributes($extensionAttributes);
        }

        $childItem = $this->getChildItem($item);
        if ($childItem) {
            $extensionAttributes = $item->getExtensionAttributes();
            $extensionAttributes->setChildItem($childItem);
            $item->setExtensionAttributes($extensionAttributes);
        }
    }

    /**
     * Get the child item for the item.
     *
     * @param \Magento\Quote\Model\Cart\Totals\Item $item
     * @return \Magento\Quote\Api\Data\TotalsItemChildInterface|null
     */
    private function getChildItem(\Magento\Quote\Model\Cart\Totals\Item $item)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('parent_item_id', $item->getItemId());
        if ($collection->getSize() > 0) {
            $data = $collection->getFirstItem()->getData();
            return $this->totalsItemChildFactory->create([
                'data' => [
                    'item_id' => $data['item_id'],
                    'product_sku' => $data['sku'],
                    'product_name' => $data['name'],
                ]
            ]);
        }
        return null;
    }
}
