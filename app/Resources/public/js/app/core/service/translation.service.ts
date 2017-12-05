import {Inject, Injectable} from '@angular/core';
// TODO load one depending on locale (maybe via JSON as well)
import 'web/js/translations/de.js';
import 'web/js/translations/en.js';
import {TranslatorInjectToken} from '../core.token';

@Injectable()
export class TranslationService {
    public constructor(@Inject(TranslatorInjectToken) private translator: BazingaJsTranslationBundle) {
    }

    public trans(id: string, parameters?: object, domain?: string): string {
        return this.translator.trans(id, parameters, domain);
    }

    public transChoice(id: string, quantity: number, parameters?: object, domain?: string): string {
        return Translator.transChoice(id, quantity, parameters, domain);
    }
}
