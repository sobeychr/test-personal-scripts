(function (doc, win, $, undefined) {
    'use strict';

    var tgp = (function() {

        var _configs = {
            backlink: 'https://www.brazzers.com/scenes/view/id/3609564/no-trespassing/',
            //backlink: './tgp?ttt',

            paramb: '?blank',
            paramt: '?ttt',
        };

        var _location = '';

        var init = function() {
            _location = win.location.toString();
            console.log('[init]', _location);

            fakeMouseEvent();

            if(isBlank()) {
                win.history.pushState({fakePage: 1}, '', '');
                win.addEventListener('popstate', onPopState);

                //win.addEventListener('mousemove', onMouseMove);
            }
        };

        var fakeMouseEvent = function() {
            win.addEventListener('mousemove', onMouseMove);

            win.dispatchEvent(new MouseEvent('mousemove', {
                screenX: -5000,
                screenY: 150,
                clientX: -5000,
                clientY: 150,
            }));

            setTimeout(function() {
                win.removeEventListener('mousemove', onMouseMove);
            }, 50);
        };

        var getLocationNoParams = function() {
            return _location
                .replace(_configs.paramb, '')
                .replace(_configs.paramt, '');
        };

        var hasParams = function() {
            return isBlank() || isTtt();
        };

        var isBlank = function() {
            return _location.indexOf(_configs.paramb) >= 0;
        };

        var isTtt = function() {
            return _location.indexOf(_configs.paramt) >= 0;
        };

        var onMouseMove = function(event) {
            console.log('[onMouseMove]', event);

            if(event.screenX < -100) {
                console.log('[onMouseMove]', 'triggered fake MouseEvent');
            }
        };

        var onPopState = function(event) {
            if(event) {
                win.location = _configs.backlink;
            }
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        tgp.init();
    });
}(document, window, jQuery));
