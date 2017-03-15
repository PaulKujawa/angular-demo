interface BazingaJsTranslationBundle {
    trans(id: string, parameters?: {}, domain?: string, locale?: string): string;
    transChoice(id: string, number: number, parameters?: {}, domain?: string, locale?: string): string;
}

/*
 * @see webpack.common.ts (ProvidePlugin)
 */
declare const Translator: BazingaJsTranslationBundle;
declare module 'web/js/translations/en.js';
declare module 'web/js/translations/de.js';
