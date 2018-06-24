require('../scss/app.scss');
require('@fortawesome/fontawesome-free');
var $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});