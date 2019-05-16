(function (doc, $, undefined) {
    'use strict';

    var parser = (function() {

        var _configs = {
            attrFunc:    'data-func',
            classEncode: 'on',

            selButtons: '.aside button',
            selInput:   '#input',
            selOutput:  '#output',

            popup: {
                delay: 7500,

                classAnim:    'popup--show',
                classDecode:  'decode',
                classEncode:  'encode',
                classFail:    'fail',
                classSuccess: 'success',
                classWarning: 'warning',

                selMain:   '#popup',
                selFunc:   '#popup .function',
                selLog:    '#popup .log',
                selResult: '#popup .result',
                selStatus: '#popup .status',
                selType:   '#popup .type'
            }
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
                isWarning = input.length === 0,
                isSuccess = output.length > 0;

            $(_configs.popup.selFunc).text(func);

            // Warning display
            if(isWarning) {
                $(_configs.popup.selResult)
                    .text('Unable to process, empty input')
                    .addClass(_configs.popup.classWarning);
            }

            // Fail or Success display
            else {
                $(_configs.selOutput).text(output);

                $(_configs.popup.selLog).text(output.length);

                $(_configs.popup.selResult)
                    .text(isSuccess ? 'success' : 'fail')
                    .addClass(isSuccess ? _configs.popup.classSuccess : _configs.popup.classFail);
                $(_configs.popup.selType)
                    .text(encode ? 'encode' : 'decode')
                    .addClass(encode ? _configs.popup.classEncode : _configs.popup.classDecode);
            }

            // Anim in
            $(_configs.popup.selMain).addClass(_configs.popup.classAnim);

            // Anim out
            setTimeout(function() {
                $(_configs.popup.selMain).removeClass(_configs.popup.classAnim);
                $(_configs.popup.selResult)
                    .removeClass(_configs.popup.classFail)
                    .removeClass(_configs.popup.classSuccess);
            }, _configs.popup.delay);
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

        var cssParse = function(str, pretty) {
            var n = str;

            if(pretty) {

            }
            else {
                n = n.replace(/\s*(\n|\r)\s*/g, '');
                n = cssRemoveComments(n);

                var q = 0;
                while(n.indexOf('\'') >= 0) {
                    n = n.replace(/\'[^\']+\'/, '$'+q);
                    q++;

                    if(q >= 50) break;
                }
            }

            return n;
        };
        var cssRemoveComments = function(str) {
            var cut = cutBetween(str, '/*', '*/');
            while(cut.length > 0)
            {
                str = str.replace(cut, '');
                cut = cutBetween(str, '/*', '*/');
            }
            return str;
        };
        
        var cutBetween = function(str, start, end) {
            var i = str.indexOf(start);
            if(i === -1) {
                return '';
            }

            var j = str.indexOf(end, i);
            if(j === -1) {
                return '';
            }
            j += end.length;

            return str.substring(i, j);
        };

        var getParse = function(str, encode) {
            var url = new URL( urlDecode(str) ),
                search = url.search.substring(1).split('&'),
                list = ['hash', 'host', 'hostname', 'origin', 'pathname', 'port', 'protocol'],
                i = '',
                key = '',
                arr = [];

            for(i in list)
            {
                key = list[i];
                if(typeof url[key] !== 'undefined') {
                    arr.push(key + ':', '\t' + url[key]);
                }
            }

            if(search.length > 0) {
                arr.push('search:', '\t' + url.search);
                for(i in search)
                {
                    arr.push('\t\t' + search[i].replace('=', ' = '));
                }
            }

            return arr.join('\n');
        };

        var jsonParse = function(str, pretty) {
            var json = str.replace(/(\n|\r)+/g, ''),
                n = '';

            try {
                n = pretty
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

        var htmlParse = function(str, pretty) {
            var n = str;

            if(pretty) {
                n = n
                    .replace(/[\ |\t]+\</g, '<')
                    .replace(/\>[\ |\t]+/g, '>')
                    .replace(/\>\</g, '>\n<')
                    .replace(/\n[\ |\t]+/g, '\n')
                    .replace(/(\n|\r)+/g, '\n')
                    .replace('\n', '');

                var a = n.split('\n'),
                    j = 0, t = ' '.repeat(4),
                    i = '', l = '',
                    r = [];

                for(i in a)
                {
                    l = a[i].toString();

                    if(htmlDeindent(l)) {
                        j--;
                    }

                    if(j < 0) {
                        j = 0;
                    }
                    r.push(t.repeat(j) + l);

                    if(htmlIndent(l)) {
                        j++;
                    }
                }

                n = r.join('\n');
            }
            else {
                n = n
                    .replace(/\s+(\r\n)*\</g, '<')
                    .replace(/\>\s+(\r\n)*/g, '>');
            }

            return n;
        };
        var htmlIndent = function(line) {
            var res = /\<\w+/.test(line)
                && line.indexOf('</') === -1
                && line.indexOf('/>') === -1;

            if(res && (
                line.indexOf('<br') >= 0
                || line.indexOf('<hr') >= 0
                || line.indexOf('<link') >= 0
            )) {
                res = false;
            }

            return res;
        };
        var htmlDeindent = function(line) {
            return line.indexOf('</') >= 0 && !/\<\w+/.test(line);
        };

        var urlParse = function(str, encode) {
            return encode ? encodeURI(str) : urlDecode(str);
        };
        var urlDecode = function(str) {
            var codes = {
                ' ' : '%20',
                '!' : '%21',
                '"' : '%22',
                '#' : '%23',
                '$' : '%24',
                '%' : '%25',
                '&' : '%26',
                '\'' : '%27',
                '(' : '%28',
                ')' : '%29',
                '*' : '%2A',
                '+' : '%2B',
                ',' : '%2C',
                '-' : '%2D',
                '.' : '%2E',
                '/' : '%2F',
                ':' : '%3A',
                ';' : '%3B',
                '<' : '%3C',
                '=' : '%3D',
                '>' : '%3E',
                '?' : '%3F',
                '@' : '40%',
                '[' : '%5B',
                '\\' : '%5C',
                ']' : '%5D',
                '^' : '%5E',
                '_' : '%5F',
                '`' : '60%',
                '{' : '%7B',
                '|' : '%7C',
                '}' : '%7D',
                '~' : '%7E',
                '`' : '80%',
                '‚' : '82%'
            };

            var i = '';
            for(i in codes)
            {
                while(str.indexOf(codes[i]) >= 0)
                {
                    str = str.replace(codes[i], i);
                }
            }

            return str;
        }

        return {
            init:  init,
        };
    })();

    $(function() {
        parser.init();
    });
}(document, jQuery));
