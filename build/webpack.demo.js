var path = require('path');
var base = require('./webpack.base');

module.exports = Object.assign(base, {
	entry: path.resolve(__dirname, '../demo/src/main.js'),
	output: {
		path: path.resolve(__dirname, '../demo/dist'),
		publicPath: '/dist/',
		filename: 'demo.js'
	},
	devServer: {
		contentBase: 'demo',
		historyApiFallback: true,
		noInfo: true
	},
	performance: {
		hints: false
	}
});