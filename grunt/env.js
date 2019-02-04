'use strict';

module.exports = grunt => {
    const ucFirst = grunt.config.get('ucFirst');

    const envFile = grunt.file.read('./.env');
    const envArr = envFile.toString().replace(/\r/g, '').split('\n');

    for(let i in envArr)
    {
        let line = envArr[i],
            j    = line.indexOf('='),
            label = line.substring(0, j),
            value = line.substring(j + 1);

        if(label.length === 0 || value.length === 0) {
            continue;
        }
        let name = 'env' + ucFirst(label);

        grunt.config.set(name, value);
        //grunt.log.writeln('env config:', name, '=', value);
    }

    let isLocal = grunt.config.get('envENV') === 'dev'
        || grunt.option('env') === 'dev';

    return {};
};