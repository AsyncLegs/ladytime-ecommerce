// webpack.config.js
let Encore = require('@symfony/webpack-encore');


let CopyWebpackPlugin = require('copy-webpack-plugin');
// important to use `unshift` since this plugin should execute first





Encore
// directory where all compiled assets will be stored
    .setOutputPath('web/assets')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/assets')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    .addEntry('application', './frontend/js/application.js')
    .addEntry('register', './frontend/js/register.js')
    .addEntry('account', './frontend/js/account/account.js')

    .createSharedEntry('vendor', [
        './frontend/js/vendor/easyResponsiveTabs.js',
        './frontend/js/vendor/jquery.wmuSlider.js',
        './frontend/js/vendor/jquery.flexisel.js',
        './frontend/js/vendor/jquery.countdown.js'

    ])

    // will output as web/build/global.css
    .addStyleEntry('global', './frontend/sass/global.scss')

    // allow sass/scss files to be processed
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())

    // create hashed filenames (e.g. app.abc123.css)
     //.enableVersioning();




// export the final configuration
module.exports = Encore.getWebpackConfig();

// or at least before ManifestPlugin to get manifest right
module.exports.plugins.unshift(new CopyWebpackPlugin([
    {
        from: './frontend/images/',
        to:  'images/'
    }
]));