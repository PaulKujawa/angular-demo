import {InjectionToken} from '@angular/core';

export function translatorFactory(): BazingaJsTranslationBundle {
    // see webpack.ProvidePlugin
    return Translator;
}

export const TranslatorInjectToken = new InjectionToken('translator');

export const translatorProvider = {provide: TranslatorInjectToken, useFactory: translatorFactory};
