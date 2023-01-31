/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');

const psRootDir = path.resolve(process.env.PWD, '../../../');
const psJsDir = path.resolve(psRootDir, 'admin-dev/themes/new-theme/js');
const psComponentsDir = path.resolve(psJsDir, 'components');

module.exports = {
  externals: {
    jquery: 'jQuery',
  },
  entry: {
    grid: './grid',
  },
  output: {
    path: path.resolve(__dirname, '../../views/js/bundle'),
    filename: '[name].js',
    libraryTarget: 'window',
    library: '[name]',

    sourceMapFilename: '[name].[hash:8].map',
    chunkFilename: '[id].[hash:8].js',
  },
  resolve: {
    extensions: ['.js'],
    alias: {
      '@components': psComponentsDir,
      '@components': path.resolve(__dirname, '../../../admin-dev/themes/new-theme/js/components'),
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        include: path.resolve(__dirname, '../grid'),
        use: [{
          loader: 'babel-loader',
          options: {
            presets: [
              ['es2015', {modules: false}],
            ],
          },
        }],
      },
      {
        test: /\.js$/,
        include: psJsDir,
        use: [{
          loader: 'babel-loader',
          options: {
            presets: [
              ['es2015', {modules: false}],
            ],
          },
        }],
      },
      {
        test: /jquery-ui\.js/,
        use: 'imports-loader?define=>false&this=>window',
      },
      {
        test: /jquery\.magnific-popup\.js/,
        use: 'imports-loader?define=>false&exports=>false&this=>window',
      },
      // FILES
      {
        test: /.(jpg|png|woff2?|eot|otf|ttf|svg|gif)$/,
        loader: 'file-loader?name=[hash].[ext]',
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(['bundle'], {
      root: path.resolve(__dirname, '../../views/js')
    }),
    new webpack.ProvidePlugin({
      $: 'jquery', // needed for jquery-ui
      jQuery: 'jquery',
    }),
  ],
}

