// styles
require('../scss/app.scss');
require('@fortawesome/fontawesome-free');
require('animate.css');
// scripts
var $ = require('jquery');
require('bootstrap');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
});

function currentYPosition() {
    // Firefox, Chrome, Opera, Safari
    if (self.pageYOffset) return self.pageYOffset;
    // Internet Explorer 6 - standards mode
    if (document.documentElement && document.documentElement.scrollTop)
        return document.documentElement.scrollTop;
    // Internet Explorer 6, 7 and 8
    if (document.body.scrollTop) return document.body.scrollTop;
    return 0;
}

function elmYPosition(eID) {
    let elm = document.getElementById(eID);
    let y = elm.offsetTop;
    let node = elm;
    while (node.offsetParent && node.offsetParent != document.body) {
        node = node.offsetParent;
        y += node.offsetTop;
    }
    return y;
}

function smoothScroll(id) {
    $('html, body').animate({ scrollTop: $('#' + id).offset().top }, 'slow');
    return false
}

const Cookies = {
    isAccepted: function () {
        return !!localStorage.acceptedCookies;
    },
    acceptCookies: function () {
        localStorage.acceptedCookies = true;
    },
    refuseCookies: function () {
        localStorage.acceptedCookies = false;
    }
};

window.currentYPosition = currentYPosition;
window.elmYPosition = elmYPosition;
window.smoothScroll = smoothScroll;
window.Cookies = Cookies;