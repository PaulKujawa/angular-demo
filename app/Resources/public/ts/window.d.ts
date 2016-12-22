interface AppInject {
    baseUrl: string;
    requestLocale: string;
}

interface BazingaJsTranslationBundle {
    trans(id: string, parameters?: {}, domain?: string, locale?: string): string;
    transChoice(id: string, number: number, parameters?: {}, domain?: string, locale?: string): string;
}

interface FosJsRouting {
    generate(route: string, params: {}): string;
    setBaseUrl(url: string): void
}

interface Window {
    appInject: AppInject;
    Routing: FosJsRouting;
    Translator: BazingaJsTranslationBundle;
}

declare module "window" {
    export = Window;
}
