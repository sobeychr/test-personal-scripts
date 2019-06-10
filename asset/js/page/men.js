(function (doc, $, undefined) {
    'use strict';

    var men = (function() {

        var _configs = {
            selDisable:   '#form button, #input',
            selDuration: '#output .duration',
            selForm:  '#form',
            selInput: '#input',
            selOutput:  '#output',
            selReset:   '#form button[type="reset"]',
            selResults: '#output .entry:not(.template), #output h2, #output pre'
        };
        var template = '';

        var init = function() {
            attachEvents();

            template = $('<div>').append($('#output .entry.template')).clone();
            template.find('.template').removeClass('template');
        };

        var attachEvents = function() {
            $(doc).on('click',  _configs.selReset, onReset);
            $(doc).on('submit', _configs.selForm,  onSubmit);
        };

        var filterEntries = function(entry) {
            return entry
                .toString()
                .replace(/[^\d]+/g, '')
                .length > 0;
        };

        var newEntry = function(data) {
            var entry = template.clone(),
                html = entry.html(),
                id = data.id,
                title = data.canonical,
                alt = /\/\d+\//.exec(data.canonical),
                codeClass = data.code === 200
                    ? 'success'
                    : data.code >= 400
                        ? 'fail'
                        : 'good';

            if(alt !== null) {
            //if(typeof alt[0] !== 'undefined') {
                alt = alt[0].toString().substring(1);
                alt = parseInt(alt.substring(0, alt.length - 1));
            }
            else {
                alt = '';
            }

            title = title.substring( data.url.indexOf(id) + id.toString().length + 2 );

            html = html
                .replace('{id}', data.id)
                .replace('{alt}', alt)
                .replace('{alt-class}', data.id === alt ? 'same' : 'different')
                .replace('{title}', title)
                .replace('{code}', data.code)
                .replace('{code-class}', codeClass)
                .replace('{sent}', urlId(id, data.url))
                .replace('{received}', urlId(id, data.canonical));

            return html;
        };

        var urlId = function(id, url) {
            if(url.indexOf(id) >= 0) {
                return url.replace(id, '<i>' + id + '</i>');
            }
            return url.replace(/\/(\d+)\//, '/<span>$1</span>/');
        }

        var onReset = function() {
            $(_configs.selResults).remove();
        };

        var onPost = function(result) {
            $(_configs.selDisable).prop('disabled', false);

            try {
                var obj = JSON.parse(result),
                    str = JSON.stringify(obj, undefined, 4),
                    results = obj.results,
                    i = '';

                // $(_configs.selOutput).prepend('<pre>' + str + '</pre>');
                $(_configs.selDuration).text(obj.duration.toString() + 's');
                for(i in results)
                {
                    $(_configs.selOutput).append( newEntry(results[i]) );
                }
            }
            catch (err) {
                $(_configs.selOutput).append('<h2>Error in response</h2><pre>' + result + '</pre><p>' + err + '</p>');
            }
        };

        var onSubmit = function(e) {
            e.preventDefault();
            onReset();

            var input = $(_configs.selInput).val().toString(),
                arr = input.split('\n');
            arr = arr.filter(filterEntries);

            $(_configs.selDisable).prop('disabled', true);
            $.post('/ajax/men.php', {ids: arr}, onPost);
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        men.init();
    });
}(document, jQuery));
