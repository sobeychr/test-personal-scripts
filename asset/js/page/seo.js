(function (doc, win, $, undefined) {
    'use strict';

    var seo = (function() {

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
            $('button, input[type="text"]').prop('disabled', false);

            try {
                var obj = JSON.parse(result),
                    robots = obj.robots,
                    i = '',
                    arr = [];

                console.log('[onPost]', robots);

                for(i in robots)
                {
                    arr.push(robots[i].fullurl);
                    arr.push('\t' + robots[i].url);
                    arr.push('\t\t' + robots[i].robString);
                }

                $('#results').text(arr.join('\n'));
            }
            catch (err) {
                $(_configs.selOutput).append('<h2>Error in response</h2><pre>' + result + '</pre><p>' + err + '</p>');
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

            $('button, input[type="text"]').prop('disabled', true);
            $.post('/ajax/seo.php', data, onPost);
        };

        return {
            init: init,
        };
    })();

    $(function() {
        seo.init();
    });
}(document, window, jQuery));
