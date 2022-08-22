define(['escaper'], function (escaper) {
    'use strict';

    return function (target) {
        return target.extend({
            /**
             * @param {Object} quoteItem
             * @return {String}
             */
            getNameUnsanitizedHtml: function (quoteItem) {
                var txt = document.createElement('textarea');

                // Check if the item has a child product, if so, use the child product name
                if (
                    quoteItem.hasOwnProperty('extension_attributes') &&
                    quoteItem.extension_attributes.hasOwnProperty('child_item')
                ) {
                    txt.innerHTML = quoteItem.extension_attributes.child_item.product_name;
                } else {
                    txt.innerHTML = quoteItem.name;
                }

                return escaper.escapeHtml(txt.value, this.allowedTags);
            },

            /**
             * @param {Object} quoteItem
             * @return {String} Magento_Checkout/js/region-updater
             */
            getValue: function (quoteItem) {
                var value = '';

                if (
                    quoteItem.hasOwnProperty('extension_attributes') &&
                    quoteItem.extension_attributes.hasOwnProperty('child_item')
                ) {
                    value = quoteItem.extension_attributes.child_item.product_name;
                } else {
                    value = quoteItem.name;
                }

                return value;
            }
        });
    };
});
