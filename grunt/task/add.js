'use strict';

module.exports = grunt => {

    const repaceAll = grunt.config.get('repaceAll');

    const module = grunt.option('mo');

    const templateDir = 'include/view/template/grunt-add/';

    const defaultFiles = grunt.config.get('addRemove');

    grunt.registerTask('add', () => {
        if(typeof module === 'undefined') {
            grunt.log.writeln('Cannot create blank module');
            return;
        }

        grunt.log.writeln('>> adding module...');
        Object.keys(defaultFiles).forEach(templateFile => {
            const destFile = defaultFiles[templateFile].replace('{mo}', module);

            var templateString = grunt.file.read(templateDir + templateFile);
            templateString = repaceAll(templateString, '{mo}', module);

            grunt.log.writeln('> ', destFile);
            grunt.file.write(destFile, templateString);
        });
    });

    return {};
};
