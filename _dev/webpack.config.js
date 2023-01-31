/**
 * Three mode available:
 *  build = production mode
 *  build:analyze = production mode with bundler analyzer
 *  dev = development mode
 */
 module.exports = () => (
    process.env.NODE_ENV === 'production' ?
      require('./.webpack/prod.js')() :
      require('./.webpack/dev.js')()
  );
  