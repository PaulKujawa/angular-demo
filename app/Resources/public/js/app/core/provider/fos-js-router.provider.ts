// TODO duplicate of fos-js-routing.d.ts
export abstract class FosJsRouter {
    public abstract generate(route: string, params: object): string;
    public abstract setBaseUrl(url: string): void;
    public abstract getBaseUrl(): string;
    public abstract getRoutes(): string[];
}

export function fosJsRouterFactory(): FosJsRouting {
    return window.Routing;
}

export const fosJsRouterProvider = {provide: FosJsRouter, useFactory: fosJsRouterFactory};
