interface FosJsRouting {
    generate(route: string, params: object): string;
    setBaseUrl(url: string): void;
    getBaseUrl(): string;
    getRoutes(): string[];
}

/*
 * FosJsRouting's router writes itself into window.Routing!
 * @see tsconfig.json, main.ts and routing-service.ts
 */
declare module 'web/bundles/fosjsrouting/js/router';
declare module 'web/js/fos_js_routes';
