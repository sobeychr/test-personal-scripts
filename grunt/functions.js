'use strict';

module.exports = grunt => {

    const repaceAll = (string, search, replace) => {
        if(replace.indexOf(search) >= 0) {
            grunt.fail.warn('Endless -replaceAll()- function in motion with "'+search+'" => "'+replace+'"', 3);
            return;
        }

        while(string.indexOf(search) >= 0) {
            string = string.replace(search, replace);
        }

        return string;
    };

    const setConfigs = (rootname, configs) => {
        for(let label in configs)
        {
            let value = configs[label],
                name  = rootname + ucFirst(label);
            if(typeof(value) === 'string' || typeof(value) === 'number') {
                grunt.config.set(name, value);
                grunt.verbose.writeln('>> config:'['cyan'], name, '=', value);
            }
            else {
                setConfigs(rootname + label, value);
            }
        }
    };

    const ucFirst = string => string.charAt(0).toUpperCase() + string.slice(1);

    grunt.config.set('repaceAll', repaceAll);
    grunt.config.set('setConfigs', setConfigs);
    grunt.config.set('ucFirst', ucFirst);

    return {};
};