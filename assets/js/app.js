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

function copyToClipboard (str) {
    const el = document.createElement('textarea');
    el.value = str;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

function enableDarkTheme() {
    if(!document.querySelector('html').classList.contains('dark_theme')) {
        document.querySelector('html').classList.add('dark_theme');
    }
    if(!document.querySelector('body').classList.contains('dark_theme')) {
        document.querySelector('body').classList.add('dark_theme');
    }
}

function disableDarkTheme() {
    if(document.querySelector('html').classList.contains('dark_theme')) {
        document.querySelector('html').classList.remove('dark_theme');
    }
    if(document.querySelector('body').classList.contains('dark_theme')) {
        document.querySelector('body').classList.remove('dark_theme');
    }
}

window.currentYPosition = currentYPosition;
window.elmYPosition = elmYPosition;
window.smoothScroll = smoothScroll;
window.Cookies = Cookies;
window.copyToClipboard = copyToClipboard;
window.$ = $;
window.setCookie = setCookie;
window.getCookie = getCookie;
window.checkCookie = checkCookie;
window.enableDarkTheme = enableDarkTheme;
window.disableDarkTheme = disableDarkTheme;