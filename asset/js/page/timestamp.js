(function (doc, $, undefined) {
    'use strict';

    var timestamp = (function() {

        var _configs = {
            attrAction: 'data-action',
            selInput:  '.input__value',
            selOutput: '.output',
            selToggle: '.toggle',

            forms: [
                '.tstodate',
                '.datetots'
            ]
        };

        var init = function() {
            $(doc).on('submit', _configs.forms.join(', '), onSubmit);

            var action = '',
                sel = '',
                i = '';
            for(i in _configs.forms)
            {
                sel    = _configs.forms[i];
                action = $(sel).attr(_configs.attrAction);
                if(typeof(action) === 'string') {
                    $(doc).on('submit', sel, eval(action));
                }
            }
        };

        var isToggle = function($form) {
            return $form.find(_configs.selToggle).is(':checked');
        };
        var getInput = function($form) {
            return $form.find(_configs.selInput).val();
        };
        var setOutput = function($form, value) {
            $form.find(_configs.selOutput).text(value);
        };
        var onSubmit = function(e) {
            e.preventDefault();
        };

        var datetots = function(e) {
            var $form = $(e.currentTarget),
                datestr = $form.find(_configs.selInput + '-date').val(),
                timestr = $form.find(_configs.selInput + '-time').val();

            if(!/^\d{4}(\-\d{2}){2}$/.test(datestr)) {
                alert('Invalid date format\nyyyy-mm-dd');
                return;
            }
            if(!/^(\d{2}\:){2}\d{2}$/.test(timestr)) {
                alert('Invalid time format\nhh:mm:ss');
                return;
            }

            var dates = datestr.split('-'),
                times = timestr.split(':'),
                date = new Date(),
                time = 0;
            date.setFullYear(dates[0]);
            date.setMonth(dates[1]);
            date.setDate(dates[2]);
            date.setHours(times[0]);
            date.setMinutes(times[1]);
            date.setSeconds(times[2]);

            time = date.getTime();
            if(!isToggle($form)) {
                time = Math.floor(time * .001);
            }

            setOutput($form, time);
        };

        var tstodate = function(e) {
            var $form = $(e.currentTarget),
                input = getInput($form),
                date  = new Date();

            if(!isToggle($form)) {
                input *= 1000;
            }

            date.setTime(input);
            setOutput($form, date.toUTCString());
        };

        return {
            init:  init,
        };
    })();

    $(function() {
        timestamp.init();
    });
}(document, jQuery));
