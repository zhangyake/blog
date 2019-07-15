const path = require('path')

const resolve = dir => {
  return path.join(__dirname, dir)
}

module.exports = {
  // proxy API requests to Valet during development
  devServer: {
    proxy: 'http://api.blog.lara'
  },  

   chainWebpack: config => {
    config.resolve.alias
        .set('@', resolve('src')) 
        // key,value自行定义，比如.set('@@', resolve('src/components'))
  },
  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../public',

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath: process.env.NODE_ENV === 'production'
    ? '../resources/views/index.blade.php'
    : 'index.html'
}
