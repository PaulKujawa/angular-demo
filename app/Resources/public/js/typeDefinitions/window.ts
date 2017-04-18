/**
 * bundles self provided type definitions
 */

interface Window {
    readonly appInject: AppInject;
    readonly Routing: FosJsRouting;
}

declare module 'window' {
    export = Window;
}
