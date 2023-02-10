'use strict'; 

const { gulp, series, parallel, watch, src, dest } = require('gulp');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const concatCss = require('gulp-concat-css');
const cleanCSS = require('gulp-clean-css');
const importCss = require('gulp-import-css');
const webpack = require('webpack');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');

const webpackConfig = process.env.NODE_ENV === "production" ? "./webpack.config.prod.js" : "./webpack.config.js";
const browserSync = require('browser-sync').create;

/**
 * Concat the javascript files into one file
 */
function compileScripts(done){
	
	return new Promise((resolve, reject) => {
		webpack(require(webpackConfig), (err, stats) => {
			if(err){
				return reject(err)
			}
			
			if(stats.hasErrors()){
				return reject(new Error(stats));
			}
			
			resolve();
		});
	});
	
		
}
/**
 * Minify the allscripts javascript
 */
function uglifyJS(){
	return src('js/dist/bundle.js')
	.pipe(uglify())
	.pipe(rename({extname: '.min.js'}))
	.pipe(dest('js/dist'));
}


function concatCSS(){
	
	return src('./styles/styles.scss')
	.pipe(sourcemaps.init())
	.pipe(sass({
		style: 'compressed', 
		includePaths: ['../node_modules', 'src'],
	}).on('error', sass.logError))
	.pipe(rename('allstyles.css'))
	.pipe(sourcemaps.write('./'))
	.pipe(dest('./styles/dist'));
	
}

/**
 * Minify the CSS 
 */
function minifyCSS(){
	return src('./styles/dist/allstyles.css')
	.pipe(cleanCSS({compatibility: 'ie8'}))
	.pipe(rename({extname: '.min.css'}))
	.pipe(dest('./styles/dist'));
}

/**
 * Run the concat CSS
 */
function watchCss(cb){
	return watch(['./styles/src/*.css', './styles/styles.scss', './styles/src/*.scss'], concatCSS);
}

/**
 * Run the concatJS function whenever a change is made to one of the javascript files
 */ 
function watchJs(cb){
	return watch(['./js/src/**/*.js', './js/**/*.js', './js/**/*.jsx', './js/**/*.ts'], series(compileScripts));

}

function reload(done){
	browserSync.reload();
	done();
}

function defaultTask(cb){
	cb();
}

exports.default = parallel(compileScripts, concatCSS);

exports.prod = parallel(series(compileScripts, uglifyJS), series(concatCSS, minifyCSS));

exports.watch = series(compileScripts, concatCSS, parallel(watchCss, watchJs));