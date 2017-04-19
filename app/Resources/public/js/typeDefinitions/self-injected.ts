// see webpack DefinePlugin
declare var process: {
    readonly env: {
        readonly ENV: 'dev'|'test'|'prod',
    },
};

// backend template 'base.html.twig'
interface AppInject {
    readonly baseUrl: string;
    readonly requestLocale: string;
    readonly authenticated: boolean;
}
