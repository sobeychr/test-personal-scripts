'use strict';

module.exports = grunt => {

    const module = grunt.option('mo');

    const defaultFiles = grunt.config.get('addRemove');

    grunt.registerTask('remove', () => {

        grunt.log.writeln('>> removing module...');
        Object.keys(defaultFiles).forEach(templateFile => {
            const destFile = defaultFiles[templateFile].replace('{mo}', module);

            grunt.log.write('> ', destFile, '- ');
            grunt.file.delete(destFile);

            const isSuccess = !grunt.file.exists(destFile);
            grunt.log.writeln(isSuccess ? 'success'['green'] : 'error'['red']);
        });
    });

    return {};
};
