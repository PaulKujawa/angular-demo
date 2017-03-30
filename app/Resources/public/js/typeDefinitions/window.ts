/**
 * bundles self provided type definitions
 */

interface Window {
    appInject: AppInject;
    Routing: FosJsRouting;
}

declare module "window" {
    export = Window;
}
