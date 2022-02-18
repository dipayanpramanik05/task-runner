var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var del = require('del');
var spritesmith = require('gulp.spritesmith');

// Function to minify and combine js files.
function jsBundle(cb) {
  gulp.src('./js/*.js')
    .pipe(concat('script.js'))
    // The gulp-uglify plugin won't update the filename
    .pipe(uglify())
    .pipe(gulp.dest('./dist/js'));
  cb();
}


// Compile, combine and minify scss files.
exports.cssBundle = function() {
  return gulp.src('./sass/**/*.scss')
    // Compile sass file.
    .pipe(sass())
    // Concat all the files into style.css file.
    .pipe(concat('style.css'))
    // Execute the task to minify the files
    .pipe(cleanCSS())
    .pipe(gulp.dest('./dist/css'));
}

// Combine and minify js files.
// exports.jsBundle = function() {
//   //return gulp.src(['js/*.js', '!js/script.js'])
//   return gulp.src('./js/*.js')
//     .pipe(concat('script.js'))
//     // The gulp-uglify plugin won't update the filename
//     .pipe(uglify())
//     .pipe(gulp.dest('./dist/js'));
// }

// Generate Image Sprite.
exports.imageSprite = function() {
   var spriteData = gulp.src('./images/icons/*.png')
    .pipe(spritesmith({
        imgName: 'sprite.png',
        cssName: 'sprite.css'
    }));
    spriteData.img.pipe(gulp.dest('./dist'));
    return spriteData.css.pipe(gulp.dest('./dist/css'));
}

// Watch css, js and image folder changes.
gulp.task('watch', function(){
    gulp.watch('js/*.js',  gulp.series('jsBundle'));
    gulp.watch('./sass/**/*.scss',  gulp.series('cssBundle'));
    gulp.watch('images/icons/*.png',  gulp.series('imageSprite'));
});

exports.jsBundle = jsBundle;
