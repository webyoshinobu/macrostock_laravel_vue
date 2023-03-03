module.exports = {
    css: {
      loaderOptions: {
        scss: {
          prependData: `
            @import "./resources/sass/mediaQuery.scss";
          `
        }
      }
    }
};
