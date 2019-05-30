(function (doc, $, undefined) {
    'use strict';

    var blur = (function() {

        var _configs = {
            btnOn:  'button.on',
            btnOff: 'button.off',
            classOn:  'on',

            selForm:  '#form',
            selInput: 'input:checkbox',
            selPreview: '*[data-img]',
            selResult:  '#results',
            selTemplate: '#results .template:first'
        };

        var init = function() {
            $(doc).on('change', _configs.selInput, onChange);
            $(doc).on('click',  _configs.btnOn,    onCheck);
            $(doc).on('click',  _configs.btnOff,   onCheck);
            $(doc).on('submit', _configs.selForm,  onSubmit);
            onPreview(true);
        };

        var onChange = function() {
            $(this).parent().toggleClass(_configs.classOn);
        };

        var onCheck = function() {
            var isChecked  = $(this).hasClass(_configs.classOn);
            var selChecked = isChecked ? ':not(:checked)' : ':checked';
            $(_configs.selInput + selChecked).trigger('click');
        };

        var onMouseEnter = function() {
            $('#preview').attr('src', $(this).attr('data-img'));
        };

        var onMouseLeave = function() {
            $('#preview').removeAttr('src');
        };

        var onPost = function(result) {
            var jsonData = JSON.parse(result);

            var date = new Date();
            date.setTime(jsonData.time * 1000);

            var dir = jsonData.dir.replace('./../', './');

            var initLength = jsonData.src.length;
            var endLength  = jsonData.images.length;
            var percent = Math.floor(initLength / endLength * 1000) * .1;

            var template = $(_configs.selTemplate).clone();
            template.removeClass('template');

            var $imgs = template.find('.imgs');
            var i = '',
                img;
            for(i in jsonData.images)
            {
                img = jsonData.images[i];
                $imgs.append('<p data-img="' + dir + img + '">' + img + '</p>')
            }

            var html = template[0].outerHTML;
            html = html
                .replace('{time}', date)
                .replace('{percent}', percent)
                .replace('{countInit}', initLength)
                .replace('{countEnd}',  endLength)
                ;

            onPreview(false);
            $(_configs.selResult).prepend(html);
            onPreview(true);
        };

        var onPreview = function(on) {
            if(on) {
                $(doc).on('mouseenter', _configs.selPreview, onMouseEnter);
                $(doc).on('mouseleave', _configs.selPreview, onMouseLeave);
            }
            else {
                $(doc).off('mouseenter mouseleave');
            }
        };

        var onSubmit = function(e) {
            e.preventDefault();

            var imgs = [];
            $(_configs.selInput + ':checked').each(function(){
                imgs.push( $(this).val() );
            });

            $.post('/ajax/blur.php', {imgs: imgs}, onPost);
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        blur.init();
    });
}(document, jQuery));
