var view = new View();

/**
 * @type {WebSocket}
 */
var connection = new WebSocket('ws://soft-group-test.dev:8080');

jQuery(document).ready(function () {
    connection.onmessage = function() {
        console.log('message');
        view.render();
    };

    connection.onopen = function () {
        console.log('initial');
        this.send('initial');
    };
});

/**
 * @constructor
 */
function View() {

    /**
     * @type {View}
     */
    var self = this;

    /**
     * Promise
     */
    this.promise = jQuery.Deferred();

    /**
     * Render view
     */
    this.render = function (params) {

        params = params ? params : self.grabParams();

        jQuery.get('/', params, function (response) {
            if (response.hasOwnProperty('dashboard')) {
                jQuery('#app-dashboard').html(response.dashboard);
            }
        });
    };

    /**
     * @param orderId
     * @returns {boolean}
     */
    this.updateOrder = function (orderId) {
        if (!orderId) {
            return false;
        }

        self.promise = jQuery.Deferred();

        var form = '#order_' + orderId;

        jQuery.post(jQuery(form).attr('action'), jQuery(form).serialize(), function (response) {
            self.promise.resolve(response);
        });

        jQuery.when(self.promise).then(function () {
            connection.send('change-order');
            self.render();
        });
    };

    /**
     * @param name
     * @param value
     * @returns {boolean}
     */
    this.setParam = function (name, value) {
        var element = jQuery('input.param[name="' + name + '"]');
        if (element.length > 0) {
            element.val(value);
            return true;
        } else {
            return false;
        }
    };

    /**
     * @returns {Object}
     */
    this.grabParams = function () {
        var params = {};

        [].slice.call(jQuery('input.param')).map(function (element) {
            element = jQuery(element);
            params[element.attr('name')] = element.attr('value');
        });

        return params;
    };
}

/**
 * Method set-param support
 */
jQuery(document).on('click', '[data-method="set-param"]', function (event) {
    event.defaultPrevented = true;
    var element = jQuery(this);
    view.setParam(element.data('name'), element.data('value'));

    view.render();
});

/**
 * Update order event
 */
jQuery(document).on('click', '.get-order', function (event) {
    event.defaultPrevented = true;
    var element = jQuery(this);

    view.updateOrder(element.data('order'));
});