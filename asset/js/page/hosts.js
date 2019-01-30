(function (doc, $, undefined) {
    'use strict';

    var hosts = (function() {

        var _configs = {
            classContent:  'chost__content--open',
            classHide:     'hidden',

            searchDelay: 320,
            searchTimer: 0,

            selAutoselect: 'input[readonly]',
            selContainter: '.chost',
            selContent: '.chost__content',
            selLink:    '.chost__link',
            selSearch:  '.search-input',
            selTitles:  '.chost > h3'
        };

        var init = function() {
            attachEvents();
        };

        var attachEvents = function() {
            $(doc).on('click', _configs.selAutoselect, autoSelect);
            $(doc).on('click', _configs.selTitles,     toggleOpen);

            $(doc).on('keydown keyup search', _configs.selSearch, searchDelay);
        };

        var autoSelect = function() {
            $(this).select();
            doc.execCommand('copy');
        };

        var searchDelay = function() {
            clearTimeout(_configs.searchTimer);
            _configs.searchTimer = setTimeout(searchLink, _configs.searchDelay);
        };

        var searchLink = function() {
            var search = $(_configs.selSearch).val().toString(),
                link   = '',
                $this  = false,
                amount = 0,
                $content = false;

            $(_configs.selLink).each(function() {
                $this = $(this),
                link  = $this.text();

                if(link.indexOf(search) === -1) {
                    $this.addClass(_configs.classHide);
                }
                else {
                    $this.removeClass(_configs.classHide);
                }
            });

            $(_configs.selContainter).each(function() {
                $this  = $(this),
                amount = $this.find(_configs.selLink).not('.' + _configs.classHide).length,
                $content = $this.find(_configs.selContent);

                if(amount === 0) {
                    $this.addClass(_configs.classHide);
                    $content.removeClass(_configs.classContent);
                }
                else {
                    $this.removeClass(_configs.classHide);

                    if(search.length > 0) {
                        $content.addClass(_configs.classContent);
                    }
                    else {
                        $content.removeClass(_configs.classContent);
                    }
                }
            });
        };

        var toggleOpen = function() {
            $(this).next(_configs.selContent).toggleClass(_configs.classContent);
        };

        return {
            init:  init,
        };
    })();

    hosts.init();
}(document, jQuery));