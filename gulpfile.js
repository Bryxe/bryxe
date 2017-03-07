var gulp = require('gulp');
var uglify = require('gulp-uglify');
var pump = require('pump');

var jspaths = [
    'scripts/*.js'
];

gulp.task('jscompress', (cb) => {
    pump([
        gulp.src(jspaths),
        uglify(),
        gulp.dest('js')
    ], cb);
});


gulp.task('watch', () => gulp.watch(jspaths, [
    'jscompress'
]))