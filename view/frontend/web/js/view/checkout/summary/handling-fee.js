define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, Component, quote, totals, priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Lovevox_CustomerSizeFee/checkout/summary/handling-fee'
            },
            isDisplayedHandlingfeeTotal: function () {
                return window.checkoutConfig.quoteData.customsizefee > 0 ? true : false;
            },
            getHandlingfeeTotal: function () {
                return this.getFormattedPrice(window.checkoutConfig.quoteData.customsizefee);
            }
        });
    }
);
