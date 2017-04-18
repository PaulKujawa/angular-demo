interface BazingaJsTranslationBundle {
    trans(id: string, parameters?: object, domain?: string, locale?: string): string;
    /* tslint:disable-next-line:variable-name */
    transChoice(id: string, number: number, parameters?: object, domain?: string, locale?: string): string;
}

/*
 * @see webpack.common.ts (ProvidePlugin)
 */
declare const Translator: BazingaJsTranslationBundle;
declare module 'web/js/translations/en.js';
declare module 'web/js/translations/de.js';
