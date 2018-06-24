// styles
require('../scss/app.scss');
require('@fortawesome/fontawesome-free');
require('animate.css');
// scripts
var $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});