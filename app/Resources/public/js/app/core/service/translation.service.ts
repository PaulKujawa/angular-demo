import {Injectable} from '@angular/core';

// TODO load one depending on locale (maybe via JSON as well)
import 'web/js/translations/de.js';
import 'web/js/translations/en.js';

@Injectable()
export class TranslationService {
    trans(id: string, parameters?: object, domain?: string): string {
        return Translator.trans(id, parameters, domain);
    }

    transChoice(id: string, number: number, parameters?: object, domain?: string): string {
        return Translator.transChoice(id, number, parameters, domain);
    }
}
