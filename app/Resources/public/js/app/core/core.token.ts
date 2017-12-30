import {InjectionToken} from '@angular/core';

// provider's factories need to be declared within core.modules to use lambda functions (likely a bug)
// provider's token though need to be declared outside of core modules to avoid ES6 import cycles

export const AuthenticatedInjectToken = new InjectionToken<boolean>('authenticated');
export const BaseUrlInjectToken = new InjectionToken<string>('baseUrl');
export const FosRouterInjectToken = new InjectionToken<FosJsRouter>('fosRouter');
export const RequestLocaleInjectToken = new InjectionToken<string>('requestLocale');
export const TranslatorInjectToken = new InjectionToken<BazingaJsTranslationBundle>('translator');
export const WindowInjectToken = new InjectionToken<Window>('window');
