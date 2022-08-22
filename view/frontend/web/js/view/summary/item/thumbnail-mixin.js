define(['escaper'], function (escaper) {
    'use strict';

    return function (target) {
        return target.extend({
            /**
             * @param {Object} item
             * @return {Array}
             */
            getImageItem: function (item) {
                var itemId = item['item_id'];

                if (
                    item.hasOwnProperty('extension_attributes') &&
                    item.extension_attributes.hasOwnProperty('child_item')
                ) {
                    itemId = item.extension_attributes.child_item.product_sku;
                }

                if (this.imageData[itemId]) {
                    return this.imageData[itemId];
                }

                return [];
            },

            /**
             * @param {Object} item
             * @return {null}
             */
            getSrc: function (item) {
                if (this.getImageItem(item)) {
                    return this.getImageItem(item).src;
                }

                return null;
            },

            /**
             * @param {Object} item
             * @return {null}
             */
            getWidth: function (item) {
                if (this.getImageItem(item)) {
                    return this.getImageItem(item).width;
                }

                return null;
            },

            /**
             * @param {Object} item
             * @return {null}
             */
            getHeight: function (item) {
                if (this.getImageItem(item)) {
                    return this.getImageItem(item).height;
                }

                return null;
            },

            /**
             * @param {Object} item
             * @return {null}
             */
            getAlt: function (item) {
                if (this.getImageItem(item)) {
                    return this.getImageItem(item).alt;
                }

                return null;
            }
        });
    };
});
