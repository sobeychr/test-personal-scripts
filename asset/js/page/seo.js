(function (doc, win, $, undefined) {
    'use strict';

    var seo = (function() {

        var secs = 0;
        var timer = 0;

        var init = function() {
            $('.buttons .add').on('click', onAdd);
            $('form').on('submit', onSubmit);
        };

        var onAdd = function() {
            var $input = $('#list .template:first').clone();
            $input.removeClass('template');
            $('#list').append($input);
        };

        var onPost = function(result) {
            $('#blocker').addClass('hidden');
            clearInterval(timer);
            timer = 0;

            try {
                var obj = JSON.parse(result),
                    robots = obj.robots,
                    template = $('#results .template:first').clone(),
                    i = '',
                    entry = '';

                template.removeClass('template');
                for(i in robots)
                {
                    entry = template[0].outerHTML
                        .replace('{fullurl}', robots[i].fullurl)
                        .replace('{url}', robots[i].url)
                        .replace('{title}', robots[i].title)
                        .replace('{robString}', robots[i].robString);

                    $('#results').append(entry);
                }
            }
            catch (err) {
                console.error('Error in response', {
                    result: result,
                    err: err
                });
            }
        };

        var onSubmit = function(e) {
            e.preventDefault();

            var data = {
                domain: $('#domain').val(),
                urls: []
            };

            $('#list input:not(.template)').each(function(){
                var $this = $(this),
                    val = $this.val().toString()
                        .replace(/^\s+/, '')
                        .replace(/\s+$/, '');

                if(val.length > 0) {
                    data.urls.push(val);
                }
            });

            $('#results .entry:not(.template)').remove();
            $('#blocker').removeClass('hidden');
            secs = 0;
            timer = setInterval(onTick, 1000);
            onTick();
            $.post('/ajax/seo.php', data, onPost);
        };

        var onTick = function() {
            $('#blocker span').text(secs + ' secs');
            secs++;
        };

        return {
            init: init,
        };
    })();

    $(function() {
        seo.init();
    });
}(document, window, jQuery));
