// webpack.config.js
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
  ...defaultConfig,
  plugins: [
    ...defaultConfig.plugins,
    new BrowserSyncPlugin(
      {
        proxy: 'https://fezziwigmedia.ddev.site', // ← replace with your dev URL
        files: ['**/*.php'],
        open: false,
        notify: false
      },
      {
        reload: true
      }
    )
  ]
};
