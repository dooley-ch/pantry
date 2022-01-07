// *******************************************************************************************
//  File:  app.js
//
//  Created: 07-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  07-12-2021: Initial version
//
// *******************************************************************************************

// ----- Flash Message -----------------------------------------------------------------------

function hideFlashMessage() {
    const flash = document.getElementById('flash-message');

    if (flash) {
        flash.classList.add('is-hidden');
    }
}

function wireUpFlashMessage() {
    const button = document.getElementById('flash-message-button');

    if (button) {
        button.addEventListener('click', () => hideFlashMessage());
    }
}

// ----- Mobile Navigation Menu --------------------------------------------------------------

function wireUpNavbarBurger() {
    const mobileMenu = document.getElementsByClassName('navbar-burger');

    Array.from(mobileMenu).forEach(function (item) {
        item.addEventListener('click', function (){
            const burgers = document.getElementsByClassName('navbar-burger');
            burgers[0].classList.toggle('is-active');

            const menus = document.getElementsByClassName('navbar-menu');
            menus[0].classList.toggle('is-active');
        }, false);
    });
}

// ----- Entry Point -------------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', function() {
    wireUpNavbarBurger();
    wireUpFlashMessage();
});
