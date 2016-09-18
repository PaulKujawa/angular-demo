interface BaInject {
    baseUrl: string;
    requestLocale: string;
}

interface FosJsRouting {
    generate(route: string, params: {}): string;
    setBaseUrl(url: string): void
}

interface Window {
    baInject: BaInject;
    Routing: FosJsRouting;
}

declare module "window" {
    export = Window;
}
