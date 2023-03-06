module.exports = {
    css: {
      loaderOptions: {
        sass: {
          prependData: `@import "./src/resources/sass/_mediaQuery.scss";`,
        }
      }
    }
};
