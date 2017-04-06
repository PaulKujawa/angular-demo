import {Pipe} from "@angular/core";
import {PipeTransform} from "@angular/core";
import {TranslationService} from "../../core/service/translation.service";

/*
 * Translate message
 *
 * Usage
 *  value|trans:params:domain
 * Example
 *  {{ 'app.common.submit'|trans }}
 *  {{ 'app.product.title'|trans:{title:'cookie'}:'messages' }}
 */

@Pipe({
    name: 'trans'
})
export class TranslationPipe implements PipeTransform {
    constructor(private translationService: TranslationService) {}

    transform(value: string, parameters?: object, domain?: string): string {
        return this.translationService.trans(value, parameters, domain);
    }
}
