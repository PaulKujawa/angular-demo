var loadAngularModules = function(forPreCompile) {
    var map = {},
        packages = {},
        modules = ['core', 'common', 'compiler', 'platform-browser', 'platform-browser-dynamic', 'http', 'router', 'forms'];

    if (forPreCompile) {
        modules.forEach(function (name) {
            packages['@angular/' + name] = {"main": "index.js", "defaultExtension": "js"};
        });
    } else {
        modules.forEach(function(name) {
            map['@angular/' + name] = '@angular/' + name + '/bundles/' + name + '.umd.js';
        });
    }

    SystemJS.config({
        packages: packages,
        map: map
    });
};

SystemJS.config({
  typescriptOptions: {
    'target': 'es5',
    'module': 'es2015',
    'emitDecoratorMetadata': true,
    'noEmitHelpers': true,
    'experimentalDecorators': true
  },
  transpiler: 'frankwallis/plugin-typescript',
  paths: {
    'github:': 'web/jspm/packages/github/',
    'npm:': 'web/jspm/packages/npm/',
    '@angular/': 'node_modules/@angular/',
    'bootstrap-sass/': 'node_modules/bootstrap-sass/',
    'rxjs/': 'node_modules/rxjs/',
    'ts-helpers': 'node_modules/ts-helpers/index.js',

    'app/': 'app/Resources/public/ts/app/',
    'app-compiled/': 'app/Resources/public/ts/app-compiled/',
    'vendor/': 'app/Resources/public/ts/vendor/'
  },
  map: {
    'bundles': 'web/bundles',
    'core-js': 'node_modules/core-js/client',
    'js': 'web/js',
    'ts-helpers': 'node_modules/ts-helpers/index.js',
    'zone.js': 'node_modules/zone.js/dist'
  },
  packages: {
    'app': {
      'main': 'bootstrap.ts',
      'defaultExtension': 'ts'
    },
    'app-compiled': {
      'defaultExtension': 'ts'
    },
    'rxjs': {
      'defaultExtension': 'js'
    },
    'vendor': {
      'main': 'vendor.ts',
      'defaultExtension': 'ts',
      'meta': {
        '*': {
          'deps': [
            'bundles/fosjsrouting/js/router.js',
            'core-js/shim.js',
            'jquery/dist/jquery.min.js',
            'js/fos_js_routes.js',
            'ts-helpers',
            'zone.js/zone.js',
            'bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
            'bootstrap-sass/assets/javascripts/bootstrap/modal.js',
            'bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            'bootstrap-sass/assets/javascripts/bootstrap/popover.js',
            'bootstrap-sass/assets/javascripts/bootstrap/transition.js'
          ]
        }
      }
    }
  }
});

loadAngularModules(typeof process !== 'undefined' && process.env.ANGULAR_PRE_COMPILE);

SystemJS.config({
  packageConfigPaths: [
    'npm:@*/*.json',
    'npm:*.json',
    'github:*/*.json'
  ],
  map: {
    'frankwallis/plugin-typescript': 'github:frankwallis/plugin-typescript@5.0.9',
    'assert': 'npm:jspm-nodelibs-assert@0.2.0',
    'buffer': 'npm:jspm-nodelibs-buffer@0.2.0',
    'child_process': 'npm:jspm-nodelibs-child_process@0.2.0',
    'constants': 'npm:jspm-nodelibs-constants@0.2.0',
    'crypto': 'npm:jspm-nodelibs-crypto@0.2.0',
    'events': 'npm:jspm-nodelibs-events@0.2.0',
    'fs': 'npm:jspm-nodelibs-fs@0.2.0',
    'path': 'npm:jspm-nodelibs-path@0.2.0',
    'jquery': 'npm:jquery@2.2.4',
    'os': 'npm:jspm-nodelibs-os@0.2.0',
    'process': 'github:jspm/nodelibs-process@0.2.0-alpha',
    'stream': 'npm:jspm-nodelibs-stream@0.2.0',
    'string_decoder': 'npm:jspm-nodelibs-string_decoder@0.2.0',
    'sync-p': 'npm:sync-p@1.1.0',
    'util': 'npm:jspm-nodelibs-util@0.2.0',
    'vm': 'npm:jspm-nodelibs-vm@0.2.0'
  },
  packages: {
    'github:frankwallis/plugin-typescript@5.0.9': {
      'map': {
        'typescript': 'npm:typescript@2.0.0'
      }
    },
    'npm:crypto-browserify@3.11.0': {
      'map': {
        'create-ecdh': 'npm:create-ecdh@4.0.0',
        'create-hash': 'npm:create-hash@1.1.2',
        'browserify-sign': 'npm:browserify-sign@4.0.0',
        'create-hmac': 'npm:create-hmac@1.1.4',
        'pbkdf2': 'npm:pbkdf2@3.0.4',
        'randombytes': 'npm:randombytes@2.0.3',
        'diffie-hellman': 'npm:diffie-hellman@5.0.2',
        'inherits': 'npm:inherits@2.0.1',
        'public-encrypt': 'npm:public-encrypt@4.0.0',
        'browserify-cipher': 'npm:browserify-cipher@1.0.0'
      }
    },
    'npm:browserify-sign@4.0.0': {
      'map': {
        'create-hash': 'npm:create-hash@1.1.2',
        'create-hmac': 'npm:create-hmac@1.1.4',
        'inherits': 'npm:inherits@2.0.1',
        'bn.js': 'npm:bn.js@4.11.6',
        'elliptic': 'npm:elliptic@6.3.1',
        'browserify-rsa': 'npm:browserify-rsa@4.0.1',
        'parse-asn1': 'npm:parse-asn1@5.0.0'
      }
    },
    'npm:create-hmac@1.1.4': {
      'map': {
        'create-hash': 'npm:create-hash@1.1.2',
        'inherits': 'npm:inherits@2.0.1'
      }
    },
    'npm:create-hash@1.1.2': {
      'map': {
        'inherits': 'npm:inherits@2.0.1',
        'cipher-base': 'npm:cipher-base@1.0.2',
        'ripemd160': 'npm:ripemd160@1.0.1',
        'sha.js': 'npm:sha.js@2.4.5'
      }
    },
    'npm:pbkdf2@3.0.4': {
      'map': {
        'create-hmac': 'npm:create-hmac@1.1.4'
      }
    },
    'npm:diffie-hellman@5.0.2': {
      'map': {
        'randombytes': 'npm:randombytes@2.0.3',
        'bn.js': 'npm:bn.js@4.11.6',
        'miller-rabin': 'npm:miller-rabin@4.0.0'
      }
    },
    'npm:cipher-base@1.0.2': {
      'map': {
        'inherits': 'npm:inherits@2.0.1'
      }
    },
    'npm:sha.js@2.4.5': {
      'map': {
        'inherits': 'npm:inherits@2.0.1'
      }
    },
    'npm:create-ecdh@4.0.0': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'elliptic': 'npm:elliptic@6.3.1'
      }
    },
    'npm:public-encrypt@4.0.0': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'create-hash': 'npm:create-hash@1.1.2',
        'randombytes': 'npm:randombytes@2.0.3',
        'browserify-rsa': 'npm:browserify-rsa@4.0.1',
        'parse-asn1': 'npm:parse-asn1@5.0.0'
      }
    },
    'npm:elliptic@6.3.1': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'inherits': 'npm:inherits@2.0.1',
        'brorand': 'npm:brorand@1.0.5',
        'hash.js': 'npm:hash.js@1.0.3'
      }
    },
    'npm:browserify-rsa@4.0.1': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'randombytes': 'npm:randombytes@2.0.3'
      }
    },
    'npm:parse-asn1@5.0.0': {
      'map': {
        'create-hash': 'npm:create-hash@1.1.2',
        'pbkdf2': 'npm:pbkdf2@3.0.4',
        'evp_bytestokey': 'npm:evp_bytestokey@1.0.0',
        'browserify-aes': 'npm:browserify-aes@1.0.6',
        'asn1.js': 'npm:asn1.js@4.8.0'
      }
    },
    'npm:miller-rabin@4.0.0': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'brorand': 'npm:brorand@1.0.5'
      }
    },
    'npm:browserify-cipher@1.0.0': {
      'map': {
        'evp_bytestokey': 'npm:evp_bytestokey@1.0.0',
        'browserify-des': 'npm:browserify-des@1.0.0',
        'browserify-aes': 'npm:browserify-aes@1.0.6'
      }
    },
    'npm:evp_bytestokey@1.0.0': {
      'map': {
        'create-hash': 'npm:create-hash@1.1.2'
      }
    },
    'npm:browserify-des@1.0.0': {
      'map': {
        'cipher-base': 'npm:cipher-base@1.0.2',
        'inherits': 'npm:inherits@2.0.1',
        'des.js': 'npm:des.js@1.0.0'
      }
    },
    'npm:browserify-aes@1.0.6': {
      'map': {
        'cipher-base': 'npm:cipher-base@1.0.2',
        'create-hash': 'npm:create-hash@1.1.2',
        'evp_bytestokey': 'npm:evp_bytestokey@1.0.0',
        'inherits': 'npm:inherits@2.0.1',
        'buffer-xor': 'npm:buffer-xor@1.0.3'
      }
    },
    'npm:hash.js@1.0.3': {
      'map': {
        'inherits': 'npm:inherits@2.0.1'
      }
    },
    'npm:asn1.js@4.8.0': {
      'map': {
        'bn.js': 'npm:bn.js@4.11.6',
        'inherits': 'npm:inherits@2.0.1',
        'minimalistic-assert': 'npm:minimalistic-assert@1.0.0'
      }
    },
    'npm:des.js@1.0.0': {
      'map': {
        'inherits': 'npm:inherits@2.0.1',
        'minimalistic-assert': 'npm:minimalistic-assert@1.0.0'
      }
    },
    'npm:stream-browserify@2.0.1': {
      'map': {
        'inherits': 'npm:inherits@2.0.1',
        'readable-stream': 'npm:readable-stream@2.1.4'
      }
    },
    'npm:buffer@4.7.1': {
      'map': {
        'base64-js': 'npm:base64-js@1.1.2',
        'ieee754': 'npm:ieee754@1.1.6',
        'isarray': 'npm:isarray@1.0.0'
      }
    },
    'npm:readable-stream@2.1.4': {
      'map': {
        'inherits': 'npm:inherits@2.0.1',
        'isarray': 'npm:isarray@1.0.0',
        'string_decoder': 'npm:string_decoder@0.10.31',
        'buffer-shims': 'npm:buffer-shims@1.0.0',
        'process-nextick-args': 'npm:process-nextick-args@1.0.7',
        'util-deprecate': 'npm:util-deprecate@1.0.2',
        'core-util-is': 'npm:core-util-is@1.0.2'
      }
    },
    'npm:jspm-nodelibs-crypto@0.2.0': {
      'map': {
        'crypto-browserify': 'npm:crypto-browserify@3.11.0'
      }
    },
    'npm:jspm-nodelibs-buffer@0.2.0': {
      'map': {
        'buffer-browserify': 'npm:buffer@4.7.1'
      }
    },
    'npm:jspm-nodelibs-os@0.2.0': {
      'map': {
        'os-browserify': 'npm:os-browserify@0.2.1'
      }
    },
    'npm:jspm-nodelibs-string_decoder@0.2.0': {
      'map': {
        'string_decoder-browserify': 'npm:string_decoder@0.10.31'
      }
    },
    'npm:jspm-nodelibs-stream@0.2.0': {
      'map': {
        'stream-browserify': 'npm:stream-browserify@2.0.1'
      }
    }
  }
});
