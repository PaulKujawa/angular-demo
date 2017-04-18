/**
 * injected either via
 * - webpack plugin 'DefinePlugin'
 * - webpack plugin 'ProvidePlugin'
 * - backend template 'base.html.twig'
 */

declare var process: Process;

type Env = 'dev'|'test'|'prod';
interface Process {
    readonly env: {
        ENV: Env;
        NODE_ENV: Env;
    };
}

interface AppInject {
    readonly baseUrl: string;
    readonly requestLocale: string;
    readonly authenticated: boolean;
}
