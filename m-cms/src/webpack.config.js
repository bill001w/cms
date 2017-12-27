const path = require('path');
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const spriteSmithPlugin = require('webpack-spritesmith');

const src = path.resolve(__dirname);
const dist = path.resolve(__dirname, '../public/dist');


module.exports = {
    entry: {
    },
    output: {
        path: dist,
        filename: '[name].bundle.js',
        publicPath: '/dist/',
    },
    module: {
        rules: [
            {
                test: /\.ejs/,
                loader: 'ejs-loader'
            },
            {
                test: /\.css$/,
                use: ['style-loader', {
                    loader: 'css-loader',
                    options: {
                        url: true,
                        // modules: true
                    },
                }],
            },
            {
                test: /\.(eot|woff|svg|woff2|ttf)$/,
                loader: 'file-loader'
            },
            {
                test: /\.(png|jpg)$/,
                loader: 'url-loader?limit=10000&name=images/[hash].[ext]'
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel-loader',
                options: {
                    presets: [["es2015", {"modules": false, "loose": true}]]
                }
            }
        ]
    },
    plugins: [
        new webpack.optimize.CommonsChunkPlugin({
            name: 'common'
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        }),
        new spriteSmithPlugin({
            src: {
                cwd: src + '/common/pc/images/',
                glob: '*/!(bg).png'
            },
            target: {
                image: dist + '/images/sprite.png',
                css: dist + '/images/sprite.css'
            },
            apiOptions: {
                cssImageRef: '../images/sprite.png'
            },
            spritesmithOptions: {
                // algorithm: 'top-down'
            }
        }),
        new HtmlWebpackPlugin({
            filename: 'pcHome.html',
            chunks: ['common', 'pcHome'],
            template: src + '/common/pc/tpl.html',
            favicon: src + '/common/pc/images/favicon.ico',
            minify: {
                removeComments: true,
                collapseWhitespace: true
            }
        })
    ]
};