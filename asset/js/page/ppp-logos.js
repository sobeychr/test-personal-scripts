(function (doc, $, undefined) {
    'use strict';

    var ppplogos = (function() {

        var _cache = {};

        var _configs = {
            attr: {
                asideActive: 'active',
                linkJson:    'data-path',
                loading:     'loading',
                product:     'data-product',
                template:    'template'
            },
            json: {
                shortname: 'shortname'
            },
            replace: '{product}',
            sel: {
                asideLink: '.aside li',
                linkJson:  '.main__json',
                loading:   '.aside, .main',
                section:   '.main section',
                secContent: '.content',
                template:  '.template'
            }
        };

        var _list = [];

        var _product = '';

        var init = function() {
            bindEvents();
        };

        var bindEvents = function() {
            $(_configs.sel.asideLink).on('click', onAsideClick);
        };


        var generateContent = function() {
            // Empty previous
            $(_configs.sel.secContent).empty();

            $(_configs.sel.section).each(function() {
                // Fetches template
                var $this  = $(this),
                    $clone = $this.find(_configs.sel.template).clone(),
                    rootHtml = '';

                $clone.removeClass(_configs.attr.template);
                rootHtml = $clone[0].outerHTML;

                // Copies for each product
                var i = '',
                    product = '',
                    entry = '';
                for(i in _list)
                {
                    product = _list[i];
                    entry = replaceAll(rootHtml, _configs.replace, product);
                    $this.find(_configs.sel.secContent).append(entry);
                }
            });
        };

        var replaceAll = function(string, search, replace) {
            while(string.indexOf(search) >= 0) {
                string = string.replace(search, replace);
            }
            return string;
        };

        var loadJson = function() {
            if(typeof _cache[_product] !== 'undefined') {
                _list = _cache[_product];
                generateContent();
                return;
            }

            var jsonPath = $(_configs.sel.linkJson).attr('href');

            if(jsonPath.indexOf(_configs.replace) >= 0) {
                return;
            }

            _list = [];
            $(_configs.sel.loading).addClass(_configs.attr.loading);
            $.get(jsonPath, onLoadJson, 'text');
        };

        var onAsideClick = function(e) {
            var $this = $(e.target);
            if($this.hasClass(_configs.attr.asideActive)) {
                return;
            }

            $(_configs.sel.asideLink).removeClass(_configs.attr.asideActive);
            $this.addClass(_configs.attr.asideActive);

            updateProduct(
                $this.attr(_configs.attr.product)
            );
        };

        var onLoadJson = function(textData) {
            $(_configs.sel.loading).removeClass(_configs.attr.loading);
            
            var jsonData = false;
            try {
                jsonData = JSON.parse(textData);
            }
            catch(e) {
                alert('Unable to parse JSON\n' + e);
                return;
            }

            var i = '',
                shortname = '';
            for(i in jsonData)
            {
                shortname = jsonData[i][ _configs.json.shortname ];
                _list.push(shortname);
            }

            /*
            console.log('Loaded', _product);
            console.log('List:', _list);
            */
            _cache[_product] = _list;
            generateContent();
        };

        var updateLinkJson = function() {
            var $a = $(_configs.sel.linkJson),
                newPath = $a.attr(_configs.attr.linkJson);

            newPath = newPath.replace(_configs.replace, _product);
            $a.attr('href', newPath);
        };

        var updateProduct = function(newProduct) {
            _product = newProduct;

            updateLinkJson();
            loadJson();
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        ppplogos.init();
    });
}(document, jQuery));
