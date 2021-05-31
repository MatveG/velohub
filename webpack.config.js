const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    entry: {
        'public/assets/app.min': './resources/js/index.js',
        'public/assets/admin/app.min': './resources/admin/index.js',
    },
    output: {
        path: path.resolve(__dirname, './'),
        filename: '[name].js',
    },
    devtool: 'source-map',
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/admin/'),
            'vue$': 'vue/dist/vue.esm.js',
        },
        extensions: ['.js', '.vue', '.json'],
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'],
                        plugins: [
                            [
                                '@babel/plugin-transform-runtime',
                                {'regenerator': true},
                            ],
                            [
                                '@babel/plugin-proposal-class-properties',
                                {'loose': true},
                            ],
                        ],
                    },
                },
            },
            {
                test: /\.s?css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[id].css',
        }),
        new VueLoaderPlugin(),
    ],
};
