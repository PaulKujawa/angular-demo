import {Inject, Injectable} from '@angular/core';
import {CoreModule} from 'app/core/core.module';
import {TranslatorInjectToken} from 'app/core/core.token';

@Injectable({
    providedIn: CoreModule,
})
export class TranslationService {
    public constructor(@Inject(TranslatorInjectToken) private translator: BazingaJsTranslationBundle) {
    }

    public trans(id: string, parameters?: object, domain?: string): string {
        return this.translator.trans(id, parameters, domain);
    }
}
