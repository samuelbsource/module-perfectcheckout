<?php
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Plugin\Cart;

/**
 * Provide images for simple products on the checkout page.
 */
class ImageProvider
{
    /**
     * @var \Magento\Quote\Api\CartItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * Constructor.
     *
     * @param \Magento\Quote\Api\CartItemRepositoryInterface $itemRepository
     * @param \Magento\Catalog\Helper\Image $imageHelper
     */
    public function __construct(
        \Magento\Quote\Api\CartItemRepositoryInterface $itemRepository,
        \Magento\Catalog\Helper\Image $imageHelper
    ) {
        $this->itemRepository = $itemRepository;
        $this->imageHelper = $imageHelper;
    }

    /**
     * If the items are configurable, return images for each simple product.
     *
     * @param \Magento\Checkout\Model\Cart\ImageProvider $subject
     * @param array $result
     * @param string $cartId
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetImages(
        \Magento\Checkout\Model\Cart\ImageProvider $subject,
        $result,
        $cartId
    ) {
        $items = $this->itemRepository->getList($cartId);

        /** @var \Magento\Quote\Model\Quote\Item $cartItem */
        foreach ($items as $cartItem) {
            $simpleItemOption = $cartItem->getOptionByCode('simple_product');
            if ($simpleItemOption) {
                $simpleProduct = $simpleItemOption->getProduct();
                $result[$simpleProduct->getSku()] = $this->getProductImageData($simpleProduct);
            }
        }

        return $result;
    }

    /**
     * Get product image data
     *
     * @param \Magento\Catalog\Model\Product $simpleProduct
     *
     * @return array
     */
    private function getProductImageData($simpleProduct)
    {
        $imageHelper = $this->imageHelper->init(
            $simpleProduct,
            'mini_cart_product_thumbnail'
        );
        $imageData = [
            'src' => $imageHelper->getUrl(),
            'alt' => $imageHelper->getLabel(),
            'width' => $imageHelper->getWidth(),
            'height' => $imageHelper->getHeight(),
        ];
        return $imageData;
    }
}
