var gulp = require('gulp'),
  less = require('gulp-less'),
  concat = require('gulp-concat'),
  autoprefixer = require('gulp-autoprefixer'),
  minifycss = require('gulp-minify-css'),
  imagemin = require('gulp-imagemin'),
  rename = require('gulp-rename'),
  uglify = require('gulp-uglify'),
  del = require('del'),
  // Bootstrap libraries need to be concatenated in a certain order.
  libraries = [
    'src/js/bootstrap/transition.js',
    'src/js/bootstrap/alert.js',
    'src/js/bootstrap/button.js',
    'src/js/bootstrap/carousel.js',
    'src/js/bootstrap/collapse.js',
    'src/js/bootstrap/dropdown.js',
    'src/js/bootstrap/modal.js',
    'src/js/bootstrap/tooltip.js',
    'src/js/bootstrap/popover.js',
    'src/js/bootstrap/scrollspy.js',
    'src/js/bootstrap/tab.js',
    'src/js/bootstrap/affix.js'
  ];

gulp.task('styles', function() {
  del(['css/style.css'], function() {
    return gulp.src('src/less/spartan.less')
      .pipe(less())
      .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
      .pipe(rename(function(path) {
        path.basename = 'style';
        path.extname = '.css';
      }))
      .pipe(gulp.dest('css'));
  });
});

gulp.task('fonts', function() {
  del(['fonts'], function() {
    return gulp.src('src/fonts/**/*.+(eot|svg|ttf|woff)')
      .pipe(rename(function(path) {
        path.dirname = '';
      }))
      .pipe(gulp.dest('fonts'));
  });
});

gulp.task('images', function() {
  del(['img'], function() {
    return gulp.src('src/img/**/*.+(jpg|png|jpeg)')
      .pipe(rename(function(path) {
        path.dirname = '';
      }))
      .pipe(gulp.dest('img'));
  });
});

gulp.task('scripts', function() {
  del(['js'], function() {
    return gulp.src(libraries)
      .pipe(concat('bootstrap.min.js'))
      .pipe(uglify())
      .pipe(gulp.dest('js'));
  });
});

gulp.task('build', ['styles', 'fonts', 'images', 'scripts'], function() {});

gulp.task('default', ['build'], function() {
  gulp.watch('src/js/**/*.js', ['scripts']);
  gulp.watch('src/less/**/*.less', ['styles']);
  gulp.watch('src/img/**/*.+(jpg|jpeg|png)', ['images']);
  gulp.watch('src/fonts/**/*.+(eot|svg|ttf|woff)', ['fonts']);
});
