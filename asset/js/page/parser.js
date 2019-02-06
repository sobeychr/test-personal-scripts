(function (doc, $, undefined) {
    'use strict';

    var parser = (function() {

        var _configs = {
            attrFunc:    'data-func',
            classEncode: 'on',
            classFooterShow: 'footer--show',

            selButtons: '.aside button',
            selFooter:  '.footer',
            selInput:   '#input',
            selOutput:  '#output'
        };

        var init = function() {
            $(doc).on('click', _configs.selButtons, onClick);
        };

        var onClick = function() {
            var $this  = $(this),
                func   = $this.attr(_configs.attrFunc),
                encode = $this.hasClass(_configs.classEncode),
                input  = $(_configs.selInput).val().toString(),
                output = eval(func+'(input,'+encode+')'),
                footer = 'Finished '+func+'('+encode+')';

            $(_configs.selOutput).text(output);

            if(output.length === 0) {
                footer += ' -- output is empty';
            }

            $(_configs.selFooter)
                .removeClass(_configs.classFooterShow)
                .delay(300)
                .text(footer)
                .addClass(_configs.classFooterShow);
        };

        var base64Encode = function(str, encode) {
            return encode ? btoa(str) : atob(str);
        };

        var charCodes = function(str, encode) {
            var i = 0, // Looping variable
                l = str.length, // Str length
                c = '', // Single character or code
                n = []; // Returned value
            
            // Encode a string
            if(encode) {
                for(i=0; i<l; i++)
                {
                    n.push(str.charCodeAt(i));
                }
            }
            // Decode string
            else {
                var j=3; // Incrementation, may differ depending on 2 or 3 characters for a code - 65 = 'A'; 115 = 's';
                while(str.length>0)
                {
                    c = parseInt(str.substring(0,j));
                    if(c>255) {
                        j = 2;
                        c = parseInt(str.substring(0, j));
                    }
                    n.push( String.fromCharCode(c) );
                    
                    if(j>str.length) {
                        break;
                    }
                    else {
                        str = str.substr(j);
                        j = 3;
                    }
                }
            }
            
            return n.join('');
        };

        var cookieParse = function(str) {
            var n = base64Encode(str, false);
            return jsonParse(n, true);
        };

        var getParse = function(str, encode) {
            return str;
        };

        var jsonParse = function(str, encode) {
            var json = str.replace(/(\n|\r)+/g, ''),
                n = '';

            try {
                n = encode
                    ? JSON.stringify(JSON.parse(json), null, 2)
                    : JSON.stringify(JSON.parse(json));
            }
            catch(err) {
                var debugN = /position\ ([0-9]+)/.exec(err),
                    cut = json;
                if(debugN !== null && typeof debugN[1] !== 'undefined') {
                    debugN = parseInt(debugN[1]);
                    debugN += (cut.substring(0, debugN).match(/(\n|\r)+/g) || []).length;
                    n = cut.substring(0, debugN);
                }
            }

            return n;
        };

        var urlParse = function(str, encode) {
            return encode ? encodeURI(str) : decodeURI(str);
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        parser.init();
    });
}(document, jQuery));
