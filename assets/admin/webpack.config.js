const path = require("path");
const outputDir = path.resolve(__dirname, "js/dist");

module.exports = {
	mode: "development",
	entry: path.resolve(__dirname, "js/index.js"),
	devtool: "inline-source-map",
	output: {
		path: outputDir,
		filename: "bundle.js"
	},
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.(js|jsx|ts)$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
				options: {
					babelrc: true
				}
			},
			{
				test: /\.ts?$/,
				loader: 'awesome-typescript-loader',
				options: { configFileName: 'tsconfig.json' }
			},
			{ 
				test: /\.ts?$/,
				loader: 'angular2-template-loader',
				options: { configFileName: 'tsconfig.json' }
			},
			{
				test: /\.ts?$/,
				loader: 'angular-router-loader',
				options: { configFileName: 'tsconfig.json' }
			},
			{
				test: /\.(js|jsx)$/,
				use: ["source-map-loader"],
				enforce: "pre"
			}
		]
	}
}