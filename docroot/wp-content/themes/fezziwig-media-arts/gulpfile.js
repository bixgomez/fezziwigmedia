// Requires Gulp v4.
// $ npm uninstall --global gulp gulp-cli
// $ rm /usr/local/share/man/man1/gulp.1
// $ npm install --global gulp-cli
// $ npm install

const { src, dest, watch, series, parallel } = require('gulp');
const browsersync = require('browser-sync').create();
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const cache = require('gulp-cached');
const notify = require('gulp-notify');
const sassGlob = require('gulp-sass-glob');

// Set compiler to use dart-sass.
sass.compiler = require('sass')

// Compile CSS from Sass.
function buildStyles() {
  return src('sass/style.scss')
    .pipe(plumbError()) // Global error handler through all pipes.
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: [
        './node_modules/breakpoint-sass/stylesheets/',
        './node_modules/@fortawesome/fontawesome-free/scss'
      ],
      errLogToConsole: true,
      outputStyle: 'compressed'
    }))
    .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7']))
    .pipe(sourcemaps.write())
    .pipe(dest('./'))
    .pipe(browsersync.reload({ stream: true }));
}

// Watch changes on all *.scss files, lint them and
// trigger buildStyles() at the end.
function watchFiles() {
  watch(
      ['sass/*.scss', 'sass/**/*.scss'],
      { events: 'all', ignoreInitial: false },
      series(buildStyles)
  );
}

// Watch changes on all *.php files, lint them and
// trigger buildStyles() at the end.
function watchPHP() {
  watch(
      ['./**/*.scss'],
      { events: 'all', ignoreInitial: false }
  );
}

// Init BrowserSync.
function browserSync(done) {
  browsersync.init({
    proxy: 'https://fezziwigmedia.ddev.site/', // Change this value to match your local URL.
    socket: {
      domain: 'localhost:3000'
    }
  });
  done();
}

// Error handler.
function plumbError() {
  return plumber({
    errorHandler: function(err) {
      notify.onError({
        templateOptions: {
          date: new Date()
        },
        title: "Gulp error in " + err.plugin,
        message:  err.formatted
      })(err);
      this.emit('end');
    }
  })
}

// Export commands.
exports.default = parallel(browserSync, watchFiles, watchPHP); // $ gulp
exports.sass = buildStyles; // $ gulp sass
exports.watch = watchFiles; // $ gulp watch
exports.build = series(buildStyles); // $ gulp build
