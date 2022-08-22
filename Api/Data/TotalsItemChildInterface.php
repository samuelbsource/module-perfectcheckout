<?php
declare(strict_types=1);

namespace PerfectShapes\PerfectCheckout\Api\Data;

/**
 * Interface for accessing simple product data from configurable cart items.
 * @api
 */
interface TotalsItemChildInterface
{
    /**
     * Get the item ID.
     *
     * @return int
     */
    public function getItemId();

    /**
     * Get the sku of the product.
     *
     * @return string
     */
    public function getProductSku();

    /**
     * Get the product name
     *
     * @return string
     */
    public function getProductName();
}
