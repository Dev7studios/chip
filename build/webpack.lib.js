var path = require('path');
var base = require('./webpack.base');

module.exports = Object.assign(base, {
	entry: path.resolve(__dirname, '../src/assets/js/lib.js'),
	output: {
		path: path.resolve(__dirname, '../dist'),
		filename: 'StripeVueComponents.js',
		library: 'StripeVueComponents',
		libraryTarget: 'umd'
	},
	externals: ['vue', 'lodash']
});