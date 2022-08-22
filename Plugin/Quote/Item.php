<?php
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Plugin\Quote;

/**
 * When the item is a configurable product, add the simple product data to the quote item.
 */
class Item
{
    /**
     * Runs after the quote item is converted to an array.
     *
     * Appends information about underlying simple product to configurable items.
     * This allows us to show the simple product image and name on the checkout page.
     *
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @param array $result
     * @param array $arrAttributes
     * @return array
     */
    public function afterToArray(
        \Magento\Quote\Model\Quote\Item $subject,
        $result,
        $arrAttributes = []
    ) {
        $simpleProduct = $this->getSimpleProduct($subject);
        if ($simpleProduct) {
            $result['simple_product'] = $simpleProduct->toArray($arrAttributes);
        }
        return $result;
    }

    /**
     * Get simple product from the configurable item if available.
     *
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @return \Magento\Catalog\Model\Product|null
     */
    private function getSimpleProduct(\Magento\Quote\Model\Quote\Item $subject)
    {
        $itemOptions = $subject->getOptions();
        foreach ($itemOptions as $itemOption) {
            if ($itemOption->getCode() == 'simple_product') {
                return $itemOption->getProduct();
            }
        }
    }
}
