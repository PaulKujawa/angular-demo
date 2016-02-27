System.config({
  defaultJSExtensions: true,
  transpiler: false,
  paths: {
    "github:*": "jspm/packages/github/*",
    "npm:*": "jspm/packages/npm/*"
  },

  map: {
    "bootstrap-sass": "github:twbs/bootstrap-sass@3.3.6",
    "jquery": "npm:jquery@2.2.1"
  }
});
