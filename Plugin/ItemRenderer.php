<?php
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Plugin;

/**
 * Override the product name and item on the cart page.
 * This allows us to show the simple product information instead of the configurable.
 */
class ItemRenderer
{
    /**
     * Return the child product name instead of the configurable product name.
     *
     * @param \Magento\Checkout\Block\Cart\Item\Renderer $subject
     * @param string $result
     */
    public function afterGetProductName(
        \Magento\Checkout\Block\Cart\Item\Renderer $subject,
        $result
    ) {
        $product = $subject->getProduct();
        if ($product->getTypeId() === 'configurable') {
            $item = $subject->getItem();
            $simpleItemOption = $item->getOptionByCode('simple_product');
            $simpleProduct = $simpleItemOption->getProduct();
            return $simpleProduct->getName();
        }
        return $result;
    }

    /**
     * Return the child product thumbnail instead of the configurable product thumbnail.
     *
     * @param \Magento\Checkout\Block\Cart\Item\Renderer $subject
     * @param \Magento\Catalog\Model\Product $result
     */
    public function afterGetProductForThumbnail(
        \Magento\Checkout\Block\Cart\Item\Renderer $subject,
        $result
    ) {
        $product = $subject->getProduct();
        if ($product->getTypeId() === 'configurable') {
            $item = $subject->getItem();
            $simpleItemOption = $item->getOptionByCode('simple_product');
            $simpleProduct = $simpleItemOption->getProduct();
            return $simpleProduct;
        }
        return $result;
    }
}
