import {Pipe} from '@angular/core';
import {PipeTransform} from '@angular/core';
import {TranslationService} from 'app/core/service/translation.service';

/*
 * Translate message
 *
 * Usage
 *  value|appTrans:params:domain
 * Example
 *  {{ 'app.common.submit'|appTrans }}
 *  {{ 'app.product.title'|appTrans:{title:'cookie'}:'messages' }}
 */

@Pipe({
    name: 'appTrans',
})
export class TranslationPipe implements PipeTransform {
    constructor(private translationService: TranslationService) {
    }

    public transform(value: string, parameters?: object, domain?: string): string {
        return this.translationService.trans(value, parameters, domain);
    }
}
