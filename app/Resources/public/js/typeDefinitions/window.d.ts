/**
 * bundles self provided type definitions
 */

interface Window {
    readonly appInject: AppInject;
    readonly Routing: FosJsRouter;
}

declare module 'window' {
    export = Window;
}
