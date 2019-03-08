(function (doc, $, undefined) {
    'use strict';

    var css = (function() {

        var _configs = {
            selClearOut: '.btn__clear-output',
            selForm: '.input__form',

            selInputOld: '.input .old textarea',
            selInputNew: '.input .new textarea',

            selOutputOld: '.output .old',
            selOutputNew: '.output .new'
        };

        var init = function() {
            $(_configs.selClearOut).on('click', onClearOutput);
            $(_configs.selForm).on('submit', onSubmit);
        };

        var onClearOutput = function() {
            $(_configs.selOutputOld).text('');
            $(_configs.selOutputNew).text('');
        };

        var onSubmit = function(e) {
            e.preventDefault();

            var textOld = $(_configs.selInputOld).val().toString(),
                textNew = $(_configs.selInputNew).val().toString();

            $(_configs.selOutputOld).text( parseCss(textOld) );
            $(_configs.selOutputNew).text( parseCss(textNew) );
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
