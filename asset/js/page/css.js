(function (doc, $, undefined) {
    'use strict';

    class Declaration {
        static sort(a, b) {
            return a.oldDecl.localeCompare(b.oldDecl);
        }

        constructor(isOld, line, text) {
            this.isOld = isOld;
            this.oldLine = line;
            this.newText = text;

            this.oldAttr = this.getAttr(this.oldLine);
            this.oldDecl = this.getDecl(this.oldLine);

            this.newLine = this.findNewLine(this.oldDecl, this.newText);
            this.newAttr = this.getAttr(this.newLine);
            this.newDecl = this.getDecl(this.newLine);
        }

        findNewLine(decl, text) {
            var i = text.indexOf(decl);
            if(i < 0) {
                return '';
            }

            var nl = text.substring(i),
                cut = nl.indexOf('\n');
            if(cut < 0) cut = nl.length;

            return nl.substring(0, cut);
        }

        getAttr(line) {
            return line.substring( line.indexOf('{') );
        }

        getDecl(line) {
            var i = line.indexOf('{');
            return i >= 0 ? line.substring(0, i) : '';
        }

        isAdded() {
            return !this.isOld && this.newLine.length === 0;
        }

        toHtml() {
            if(this.isAdded()) {
                return `<p class="add">${this.oldLine}</p>`;
            }
            else if(this.newLine.length === 0) {
                return `<p class="remove">${this.oldLine}</p>`;
            }
            else if(this.oldLine !== this.newLine) {
                return `<p class="diff">
                    <span class="old">${this.oldLine}</span>
                    <span class="new">${this.newAttr}</span>
                </p>`;
            }
            return `<p class="same">${this.oldLine}</p>`;
        }
    };

    var css = (function() {

        var _configs = {
            selClearOut: '.btn__clear-output',
            selForm: '.input__form',

            selInputOld: '.input__old textarea',
            selInputNew: '.input__new textarea',

            selOutput: '.output'
        };

        var init = function() {
            $(_configs.selClearOut).on('click', onClearOutput);
            $(_configs.selForm).on('submit', onSubmit);
        };

        var getDeclarations = function(isOld, oldText, newText) {
            var arr = oldText.split('\n'),
                i = '', l = '', d = false,
                r = [];

            for(i in arr)
            {
                l = arr[i].toString();
                d = new Declaration(isOld, l, newText);

                if(d.oldLine.length > 0 && (isOld || d.isAdded()) ) {
                    r.push(d);
                }
            }

            return r;
        };

        var getParsedText = function() {
            var textOld = $(_configs.selInputOld).val().toString(),
                textNew = $(_configs.selInputNew).val().toString(),
                parseOld = parseCss(textOld),
                parseNew = parseCss(textNew);

            return [parseOld, parseNew];
        };

        var onClearOutput = function() {
            $(_configs.selOutput).empty();
        };

        var onSubmit = function(e) {
            e.preventDefault();

            var parsed = getParsedText(),
                result = getDeclarations(true, parsed[0], parsed[1]),
                html = [];

            result = result.concat( getDeclarations(false, parsed[1], parsed[0]) );
            result.sort(Declaration.sort);

            html = result.map(function(d){ return d.toHtml(); });
            $(_configs.selOutput).html( html.join('') );
        };

        var parseCss = function(input) {
            var outputStr = input.replace(/\}/g, '}\n'),
                outputArr = outputStr.split('\n');
            
            outputArr.sort();
            return outputArr.join('\n');
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        css.init();
    });
}(document, jQuery));
