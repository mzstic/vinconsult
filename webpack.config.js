var webpack = require('webpack');

var config = {
    context: __dirname + '/client-src',
    entry: {
        app: './app.js',
    },
    output: {
        path: __dirname + '/web/js',
        filename: 'bundle.js',
    },
};

module.exports = config;