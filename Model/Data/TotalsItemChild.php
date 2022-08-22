<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Model\Data;

use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Api\AbstractExtensibleObject;
use PerfectShapes\PerfectCheckout\Api\Data\TotalsItemChildInterface;

/**
 * Data Model for simple product item data.
 */
class TotalsItemChild extends AbstractExtensibleObject implements TotalsItemChildInterface
{
    public const KEY_ITEM_ID = 'item_id';
    public const KEY_PRODUCT_SKU = 'product_sku';
    public const KEY_PRODUCT_NAME = 'product_name';

    /**
     * Get the product ID.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->_get(self::KEY_ITEM_ID);
    }

    /**
     * Get the sku of the product.
     *
     * @return string
     */
    public function getProductSku()
    {
        return $this->_get(self::KEY_PRODUCT_SKU);
    }

    /**
     * Get the product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->_get(self::KEY_PRODUCT_NAME);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return ExtensionAttributesInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     *
     * @param ExtensionAttributesInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        ExtensionAttributesInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
