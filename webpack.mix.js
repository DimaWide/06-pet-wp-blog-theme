const mix = require('laravel-mix');

mix.webpackConfig({
	stats: {
		children: true
	}
});

// JS
// ToDo: Remove comment for compile JS
/*
mix.js('js/modules/*.js', 'js/wcl-functions.js');
*/

// SCSS
mix.options({
	// Don't perform any css url rewriting by default
	processCssUrls: false,
	postCss: [
		// Adding vendor prefixes to CSS
		require('autoprefixer'),
		// Grouping styles by media queries
		require('postcss-sort-media-queries'),
	],
})

mix.sass('scss/wcl-style.scss', 'css')
	.sourceMaps();

mix.sass('scss/wcl-admin-style.scss', 'css')
	.sourceMaps();

// ACF Blocks
// ToDo: Remove comment for compile ACF blocks SCSS
/*
mix.sass('template-parts/acf-blocks/main-banner/main-banner.scss', 'template-parts/acf-blocks/main-banner')
	.sourceMaps();
*/
