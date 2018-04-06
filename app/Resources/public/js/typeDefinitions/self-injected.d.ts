// dev and prod are set by webpack while test comes from karma.conf.js
declare var process: {
    readonly env: {
        readonly NODE_ENV: 'production' | 'test' | 'production',
    },
};

// base template 'base.html.twig'
interface AppInject {
    readonly baseUrl: string;
    readonly requestLocale: string;
    readonly authenticated: boolean;
}
