const path = require( 'path' );
const webpack = require( 'webpack' );

module.exports = {
  entry: {
    './lib/admin/js/timeline-express-blocks' : './lib/admin/blocks/blocks.js',
  },
  output: {
    path: path.resolve( __dirname ),
    filename: '[name].js',
  },
  watch: false,
  devtool: 'cheap-eval-source-map',
	module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
  plugins: [],
};
