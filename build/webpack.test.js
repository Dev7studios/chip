var base = require('./webpack.base');

module.exports = Object.assign(base, {
	devtool: '#inline-source-map'
});
