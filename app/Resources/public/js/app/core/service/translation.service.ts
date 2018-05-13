import {Inject, Injectable} from '@angular/core';
import {TranslatorInjectToken} from '../core.token';

@Injectable()
export class TranslationService {
    public constructor(@Inject(TranslatorInjectToken) private translator: BazingaJsTranslationBundle) {
    }

    public trans(id: string, parameters?: object, domain?: string): string {
        return this.translator.trans(id, parameters, domain);
    }
}
