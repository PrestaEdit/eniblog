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
 
 module.exports = {
   externals: {
     jquery: 'jQuery',
   },
   entry: {
    configure: './src/configure',
   },
   output: {
     path: path.resolve(__dirname, '../../../views/js'),
     filename: '[name].bundle.js',
     libraryTarget: 'window',
     library: '[name]',
 
     sourceMapFilename: '[name].[hash:8].map',
     chunkFilename: '[id].[hash:8].js',
   },
   resolve: {
     extensions: ['.ts', '.js', '.vue', '.json'],
     alias: {
       vue$: 'vue/dist/vue.common.js',
       '@app': path.resolve(__dirname, '../js/app'),
       '@js': path.resolve(__dirname, '../js'),
       '@pages': path.resolve(__dirname, '../js/pages'),
       '@components': path.resolve(__dirname, '../../../../../admin-dev/themes/new-theme/js/components'),
       '@scss': path.resolve(__dirname, '../scss'),
       '@node_modules': path.resolve(__dirname, '../node_modules'),
       '@vue': path.resolve(__dirname, '../js/vue'),
       '@PSTypes': path.resolve(__dirname, '../js/types'),
       '@images': path.resolve(__dirname, '../img'),
     },
   },
   module: {
     rules: [
       {
         test: /\.vue$/,
         loader: 'vue-loader',
       },
       {
         test: /\.js$/,
         include: path.resolve(__dirname, '../js'),
         use: [
           {
             loader: 'esbuild-loader',
           },
         ],
       },
       {
         test: /\.ts?$/,
         include: path.resolve(__dirname, '../js'),
         loader: 'esbuild-loader',
         options: {
           loader: 'ts',
           target: 'es2015',
         },
         exclude: /node_modules/,
       },
       {
         test: /jquery-ui\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
             },
           },
         },
       },
       {
         test: /jquery\.magnific-popup\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
               exports: false,
             },
           },
         },
       },
       {
         test: /bloodhound\.min\.js/,
         use: [
           {
             loader: 'expose-loader',
             options: {
               exposes: 'Bloodhound',
             },
           },
         ],
       },
       {
         test: /dropzone\/dist\/dropzone\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               module: null,
             },
           },
         },
       },
       {
         test: /typeahead\.jquery\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
               exports: false,
             },
           },
         },
       },
       {
         test: /bootstrap-tokenfield\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
               exports: false,
             },
           },
         },
       },
       {
         test: /bootstrap-datetimepicker\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
               exports: false,
             },
           },
         },
       },
       {
         test: /bootstrap-colorpicker\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               define: false,
               exports: false,
             },
           },
         },
       },
       {
         test: /jwerty\/jwerty\.js/,
         loader: 'imports-loader',
         options: {
           wrapper: {
             thisArg: 'window',
             args: {
               module: false,
             },
           },
         },
       },
       // FILES
       {
         test: /.(jpg|png|woff2?|eot|otf|ttf|svg|gif)$/,
         loader: 'file-loader',
         options: {
           name: '[hash].[ext]',
         },
         exclude: /MaterialIcons-Regular\.(woff2?|ttf)$/,
       },
       {
         test: /MaterialIcons-Regular\.(woff2?|ttf)$/,
         loader: 'file-loader',
         options: {
           name: '[hash].preload.[ext]',
         },
       },
     ],
   },
   plugins: [
     new webpack.ProvidePlugin({
       $: 'jquery', // needed for jquery-ui
       jQuery: 'jquery',
     }),
   ],
 };
 